<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestBantuan;
use Illuminate\Support\Facades\Auth;

class RequestBantuanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kebutuhan' => 'required|in:makanan,obat,pakaian',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $requestBantuan = RequestBantuan::create([
            'user_id' => Auth::id(),
            'jenis_kebutuhan' => $validated['jenis_kebutuhan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
        ->route('request-bantuan.create')
        ->with('success', 'Permintaan bantuan berhasil dikirim.');
    }
}

