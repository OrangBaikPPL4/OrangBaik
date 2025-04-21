<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Misi;
use App\Models\Relawan;
use Illuminate\Support\Facades\Auth;

class MisiController extends Controller
{
    public function index()
    {
        // Different views for admin and volunteer
        if (Auth::user()->usertype === 'admin') {
            // Admin sees all missions with complete details
            $misis = Misi::with('relawan')->get();
            return view('misi.admin_index', compact('misis'));
        } else {
            // Volunteers see available missions
            $misis = Misi::where('status', 'aktif')->get();
            
            // Get user's volunteer profile if exists
            $relawan = Relawan::where('user_id', Auth::id())->first();
            
            return view('misi.index', compact('misis', 'relawan'));
        }
    }
    
    public function create()
    {
        // Only admin can create missions
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('misi.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        return view('misi.create');
    }
    
    public function store(Request $request)
    {
        // Only admin can store new missions
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('misi.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $request->validate([
            'nama_misi' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,dalam proses,selesai'
        ]);
        
        Misi::create($request->all());
        
        return redirect()->route('misi.index')->with('success', 'Misi bantuan berhasil dibuat!');
    }
    
    public function show($id)
    {
        $misi = Misi::with('relawan')->findOrFail($id);
        
        // Get user's volunteer profile if exists
        $relawan = Relawan::where('user_id', Auth::id())->first();
        $isJoined = false;
        
        if ($relawan) {
            $isJoined = $relawan->misi->contains($id);
        }
        
        return view('misi.show', compact('misi', 'relawan', 'isJoined'));
    }
    
    public function edit($id)
    {
        // Only admin can edit missions
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('misi.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $misi = Misi::findOrFail($id);
        
        return view('misi.edit', compact('misi'));
    }
    
    public function update(Request $request, $id)
    {
        // Only admin can update missions
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('misi.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $request->validate([
            'nama_misi' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,dalam proses,selesai'
        ]);
        
        $misi = Misi::findOrFail($id);
        $misi->update($request->all());
        
        return redirect()->route('misi.index')->with('success', 'Data misi berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        // Only admin can delete missions
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('misi.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $misi = Misi::findOrFail($id);
        $misi->delete();
        
        return redirect()->route('misi.index')->with('success', 'Misi berhasil dihapus!');
    }

    public function gabungMisi(Request $request, $id)
    {
        $misi = Misi::findOrFail($id);
        
        // Get the volunteer profile of the current user
        $relawan = Relawan::where('user_id', Auth::id())->first();
        
        if (!$relawan) {
            return redirect()->route('relawan.create')->with('error', 'Anda harus mendaftar sebagai relawan terlebih dahulu!');
        }
        
        // Check if already joined
        if ($relawan->misi->contains($id)) {
            return back()->with('error', 'Anda sudah bergabung dengan misi ini!');
        }
        
        // Join the mission
        $misi->relawan()->attach($relawan->id);
        
        // Update volunteer status to "bertugas"
        $relawan->update(['status' => 'bertugas']);
        
        return back()->with('success', 'Berhasil gabung misi!');
    }

    public function laporProgress(Request $request, $id)
    {
        $request->validate([
            'laporan' => 'required'
        ]);
        
        $misi = Misi::findOrFail($id);
        
        // Get the volunteer profile of the current user
        $relawan = Relawan::where('user_id', Auth::id())->first();
        
        if (!$relawan) {
            return back()->with('error', 'Anda harus mendaftar sebagai relawan terlebih dahulu!');
        }
        
        // Check if volunteer is part of this mission
        if (!$relawan->misi->contains($id)) {
            return back()->with('error', 'Anda belum bergabung dengan misi ini!');
        }
        
        // Update the pivot table with the report
        $misi->relawan()->updateExistingPivot($relawan->id, [
            'laporan' => $request->laporan,
        ]);
        
        return back()->with('success', 'Laporan progress dikirim!');
    }
    
    public function updateMisiStatus(Request $request, $id)
    {
        // Only admin can update mission status
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin!');
        }
        
        $request->validate([
            'status' => 'required|in:aktif,dalam proses,selesai'
        ]);
        
        $misi = Misi::findOrFail($id);
        $misi->update(['status' => $request->status]);
        
        // If mission is completed, update the status of all volunteers in this mission
        if ($request->status === 'selesai') {
            foreach ($misi->relawan as $relawan) {
                $relawan->update(['status' => 'selesai']);
            }
        }
        
        return redirect()->back()->with('success', 'Status misi diperbarui!');
    }
}