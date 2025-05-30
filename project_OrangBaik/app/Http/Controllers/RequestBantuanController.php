<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestBantuan;
use Illuminate\Support\Facades\Auth;

class RequestBantuanController extends Controller
{
    /**
     * Menyimpan permintaan bantuan dari korban (PBI29)
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
     * Menampilkan riwayat permintaan bantuan milik user (PBI32)
     */
    public function index()
    {
        $requests = RequestBantuan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('request-bantuan.index', compact('requests'));
    }

    /**
     * Menampilkan semua permintaan untuk admin + filter jenis kebutuhan (PBI30 + PBI31)
     */
    public function adminIndex(Request $request)
    {
        $query = RequestBantuan::with('user'); // Eager load relasi user

        // Filter berdasarkan jenis kebutuhan
        if ($request->filled('jenis_kebutuhan')) {
            $query->where('jenis_kebutuhan', $request->jenis_kebutuhan);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at'); // default: created_at
        $order = $request->get('order', 'desc'); // default: desc

        // Validasi kolom yang boleh digunakan untuk sorting
        $allowedSorts = ['status', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        // Validasi arah urutan
        $allowedOrders = ['asc', 'desc'];
        if (!in_array($order, $allowedOrders)) {
            $order = 'desc';
        }

        $requests = $query->orderBy($sortBy, $order)->get();

        return view('admin.request.index', compact('requests'));
    }

    /**
     * Admin mengubah status permintaan bantuan (PBI31)
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        $req = RequestBantuan::findOrFail($id);
        $req->status = $validated['status'];
        $req->save();

        return redirect()
            ->route('admin.request-bantuan.index')
            ->with('success', 'Status permintaan berhasil diperbarui.');
    }
}
