<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestBantuan;
use Illuminate\Support\Facades\Auth;

class RequestBantuanController extends Controller
{
    // Menyimpan permintaan bantuan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kebutuhan' => 'required|in:makanan,obat,pakaian',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        RequestBantuan::create([
            'user_id' => Auth::id(),
            'jenis_kebutuhan' => $validated['jenis_kebutuhan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('request-bantuan.create')
            ->with('success', 'Permintaan bantuan berhasil dikirim.');
    }

    // Menampilkan riwayat permintaan bantuan user
    public function index()
    {
        $requests = RequestBantuan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('request-bantuan.index', compact('requests'));
    }

    public function adminIndex()
    {
    $requests = \App\Models\RequestBantuan::orderBy('created_at', 'desc')->get();

    return view('admin.request.index', compact('requests'));
    }

    public function updateStatus(Request $request, $id)
    {
    $request->validate([
        'status' => 'required|in:pending,diproses,selesai,ditolak',
    ]);

    $req = \App\Models\RequestBantuan::findOrFail($id);
    $req->status = $request->status;
    $req->save();

    return redirect()->route('admin.request-bantuan.index')->with('success', 'Status berhasil diperbarui.');
    }

}

