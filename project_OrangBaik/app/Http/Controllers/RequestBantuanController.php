<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestBantuan;
use Illuminate\Support\Facades\Auth;

class RequestBantuanController extends Controller
{
    /**
     * Menyimpan permintaan bantuan dari korban
     */
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

    /**
     * Menampilkan riwayat permintaan bantuan user (korban)
     */
    public function index()
    {
        $requests = RequestBantuan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('request-bantuan.index', compact('requests'));
    }

    /**
     * Menampilkan semua permintaan bantuan untuk admin (bisa difilter berdasarkan jenis bantuan)
     */
    public function adminIndex(Request $request)
    {
        $query = RequestBantuan::query();

        // Filter berdasarkan jenis kebutuhan jika ada
        if ($request->filled('jenis_kebutuhan')) {
            $query->where('jenis_kebutuhan', $request->jenis_kebutuhan);
        }

        $requests = $query->orderBy('created_at', 'desc')->get();

        return view('admin.request.index', compact('requests'));
    }

    /**
     * Mengupdate status permintaan bantuan (oleh admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        $req = RequestBantuan::findOrFail($id);
        $req->status = $request->status;
        $req->save();

        return redirect()
            ->route('admin.request-bantuan.index')
            ->with('success', 'Status berhasil diperbarui.');
    }
}
