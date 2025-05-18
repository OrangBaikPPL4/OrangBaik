<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Auth;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonis = Testimoni::where('status', 'verified')->latest()->get();
        return view('testimoni.index', compact('testimonis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('testimoni.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
            'jenis_bencana' => 'required|string',
            'jenis_bencana_lain' => 'nullable|string|max:255',
            'isicerita' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_testimoni', 'public');
        }

        Testimoni::create([
            'nama' => Auth::user()->name,
            'lokasi' => $request->lokasi,
            'jenis_bencana' => $request->jenis_bencana === 'lainnya' ? $request->jenis_bencana_lain : $request->jenis_bencana,
            'isicerita' => $request->isicerita,
            'foto' => $fotoPath,
            'status' => 'pending',
        ]);

        return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil dikirim dan menunggu persetujuan admin.');
    }
    public function moderation()
    {
        $testimonis = Testimoni::where('status', 'pending')->get();
        return view('admin.testimoni.moderation', compact('testimonis'));
    }

    // PBI#41: Menyetujui testimoni
    public function approve($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->status = 'verified';
        $testimoni->save();

        return redirect()->back()->with('success', 'Testimoni telah disetujui.');
    }

    // PBI#41: Menolak testimoni
    public function reject($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->status = 'rejected';
        $testimoni->save();

        return redirect()->back()->with('success', 'Testimoni telah ditolak.');
    }
}
