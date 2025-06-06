<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Relawan;
use App\Models\Misi;
use Illuminate\Support\Facades\Auth;

class RelawanController extends Controller
{
    public function index(Request $request)
    {
        // For admins - show all volunteers with search functionality
        if (Auth::user()->usertype === 'admin') {
            try {
                $query = Relawan::query();
                
                // Handle search
                if ($request->has('search')) {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%')
                          ->orWhere('lokasi', 'like', '%' . $search . '%');
                    });
                }
                
                $relawans = $query->get();
                return view('relawan.index', compact('relawans'));
            } catch (\Exception $e) {
                // Tangkap error jika ada
                return view('relawan.index', [
                    'relawans' => collect(),
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // For regular users - redirect to their own volunteer profile
        $relawan = Relawan::where('user_id', Auth::id())->first();
        if ($relawan) {
            return redirect()->route('relawan.show');
        } else {
            // If user doesn't have a volunteer profile yet, show the index with empty data
            $relawans = collect();
            return view('relawan.index', compact('relawans'));
        }
    }

    public function create()
    {
        // Check if user already has a volunteer profile
        $existingRelawan = Relawan::where('user_id', Auth::id())->first();
        
        if ($existingRelawan) {
            return redirect()->route('relawan.show')->with('error', 'Anda sudah terdaftar sebagai relawan!');
        }
        
        return view('relawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:relawans',
            'telepon' => 'nullable',
            'lokasi' => 'nullable',
        ]);

        // Create new profile
        $relawan = new Relawan($request->all());
        $relawan->user_id = Auth::id();
        $relawan->verification_status = 'pending';
        $relawan->save();

        return redirect()->route('relawan.index')->with('success', 'Pendaftaran relawan berhasil dikirim dan sedang menunggu verifikasi admin!');
    }
    
    public function show($id = null)
    {
        // If admin is viewing a specific relawan
        if (Auth::user()->usertype === 'admin' && $id) {
            $relawan = Relawan::with('misi')->findOrFail($id);
            $misiRelawan = $relawan->misi;
            return view('relawan.admin-show', compact('relawan', 'misiRelawan'));
        }
        
        // Show individual relawan profile for the logged in user
        $relawan = Relawan::with('misi')->where('user_id', Auth::id())->firstOrFail();
        
        // Get missions the volunteer is part of
        $misiRelawan = $relawan->misi;
        
        return view('relawan.show', compact('relawan', 'misiRelawan'));
    }
    
    public function edit($id)
    {
        $relawan = Relawan::findOrFail($id);
        
        // Only allow editing if user is admin or owns this volunteer profile
        if (Auth::user()->usertype !== 'admin' && $relawan->user_id !== Auth::id()) {
            return redirect()->route('relawan.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        // Use different view for admin and regular users
        if (Auth::user()->usertype === 'admin') {
            return view('relawan.admin-edit', compact('relawan'));
        } else {
            return view('relawan.edit', compact('relawan'));
        }
    }
    
    public function update(Request $request, $id)
    {
        $relawan = Relawan::findOrFail($id);
        
        // Only allow updating if user is admin or owns this volunteer profile
        if (Auth::user()->usertype !== 'admin' && $relawan->user_id !== Auth::id()) {
            return redirect()->route('relawan.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:relawans,email,' . $id,
            'telepon' => 'nullable',
            'lokasi' => 'nullable',
        ]);
        
        $relawan->update($request->all());
        
        return redirect()->route('relawan.index')->with('success', 'Data relawan berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $id)
    {
        // Only admins can update volunteer status
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin!');
        }
        
        $relawan = Relawan::findOrFail($id);
        
        // Jika request berisi verification_status, update status verifikasi
        if ($request->has('verification_status')) {
            $relawan->update(['verification_status' => $request->verification_status]);
            
            $message = $request->verification_status == 'approved' 
                ? 'Pendaftaran relawan berhasil disetujui!' 
                : 'Pendaftaran relawan ditolak!';
                
            return redirect()->back()->with('success', $message);
        }
        
        // Jika tidak, update status biasa
        $relawan->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Status relawan diperbarui!');
    }
    
    public function misiRelawan()
    {
        // Get current user's volunteer data
        $relawan = Relawan::with('misi')->where('user_id', Auth::id())->firstOrFail();
        
        // Get missions the volunteer is part of
        $misiRelawan = $relawan->misi;
        
        // Get available missions
        $misiTersedia = Misi::where('status', 'aktif')
            ->whereNotIn('id', $misiRelawan->pluck('id'))
            ->get();
        
        return view('relawan.misi', compact('relawan', 'misiRelawan', 'misiTersedia'));
    }

    public function destroy($id)
    {
        $relawan = Relawan::findOrFail($id);
        
        // Only allow deletion if user is admin or owns this volunteer profile
        if (Auth::user()->usertype !== 'admin' && $relawan->user_id !== Auth::id()) {
            return redirect()->route('relawan.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $relawan->delete();
        
        return redirect()->route('relawan.index')->with('success', 'Relawan berhasil dihapus!');
    }
}
