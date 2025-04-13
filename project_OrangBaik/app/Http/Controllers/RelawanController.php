<?php

namespace App\Http\Controllers;

use App\Models\Relawan;
use Illuminate\Http\Request;

class RelawanController extends Controller

{
    // Menampilkan data relawan
    public function index()
    {
        $relawans = Relawan::all();
        return view('relawan.index', compact('relawans'));
    }

    // Menyimpan data relawan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email',
            'no_telepon' => 'nullable|string',
        ]);

        Relawan::create($request->all());

        return redirect()->route('relawan.index');
    }

    // Menampilkan form untuk menambah relawan
    public function create()
    {
        return view('relawan.create');
    }
}

{
    //
}
