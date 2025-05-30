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
            'status' => 'required|in:aktif,dalam proses,selesai',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/misi'), $imageName);
            $data['image_url'] = '/images/misi/' . $imageName;
        }
        
        Misi::create($data);
        
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

        // Get available volunteers for admin
        $relawanTersedia = null;
        if (Auth::user()->usertype === 'admin') {
            $relawanTersedia = Relawan::where('verification_status', 'approved')
                                   ->whereNotIn('id', $misi->relawan->pluck('id'))
                                   ->get();
            return view('misi.admin-show', compact('misi', 'relawan', 'isJoined', 'relawanTersedia'));
        }
        
        return view('misi.show', compact('misi', 'relawan', 'isJoined', 'relawanTersedia'));
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
            'status' => 'required|in:aktif,dalam proses,selesai',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $misi = Misi::findOrFail($id);
        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($misi->image_url && file_exists(public_path($misi->image_url))) {
                @unlink(public_path($misi->image_url));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/misi'), $imageName);
            $data['image_url'] = '/images/misi/' . $imageName;
        }
        
        $misi->update($data);
        
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
        
        // Check if the volunteer is verified
        if ($relawan->verification_status !== 'approved') {
            return back()->with('error', 'Pendaftaran relawan Anda masih menunggu verifikasi atau ditolak. Anda hanya dapat bergabung dengan misi setelah pendaftaran disetujui.');
        }
        
        // Check if already joined
        if ($relawan->misi->contains($id)) {
            return back()->with('error', 'Anda sudah bergabung dengan misi ini!');
        }
        
        // Check if mission has reached its volunteer quota
        $currentVolunteers = $misi->relawan->count();
        if ($misi->kuota_relawan > 0 && $currentVolunteers >= $misi->kuota_relawan) {
            return back()->with('error', 'Kuota relawan untuk misi ini sudah penuh!');
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

    public function tambahRelawan(Request $request, $id)
    {
        // Only admin can add volunteers
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin!');
        }

        $request->validate([
            'relawan_id' => 'required|exists:relawans,id'
        ]);

        $misi = Misi::findOrFail($id);
        $relawan = Relawan::findOrFail($request->relawan_id);

        // Check if volunteer is already in the mission
        if ($misi->relawan->contains($relawan->id)) {
            return redirect()->back()->with('error', 'Relawan sudah bergabung dalam misi ini!');
        }
        
        // Check if mission has reached its volunteer quota
        $currentVolunteers = $misi->relawan->count();
        if ($misi->kuota_relawan > 0 && $currentVolunteers >= $misi->kuota_relawan) {
            return redirect()->back()->with('error', 'Kuota relawan untuk misi ini sudah penuh!');
        }

        // Add volunteer to mission
        $misi->relawan()->attach($relawan->id);
        
        // Update volunteer status to "bertugas"
        $relawan->update(['status' => 'bertugas']);

        return redirect()->back()->with('success', 'Relawan berhasil ditambahkan ke misi!');
    }

    public function hapusRelawan($misi_id, $relawan_id)
    {
        // Only admin can remove volunteers
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin!');
        }

        $misi = Misi::findOrFail($misi_id);
        $relawan = Relawan::findOrFail($relawan_id);

        // Remove volunteer from mission
        $misi->relawan()->detach($relawan->id);
        
        // Update volunteer status to "aktif"
        $relawan->update(['status' => 'aktif']);

        return redirect()->back()->with('success', 'Relawan berhasil dihapus dari misi!');
    }
}