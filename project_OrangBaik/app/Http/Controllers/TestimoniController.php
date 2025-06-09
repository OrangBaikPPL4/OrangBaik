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
    public function index(Request $request)
    {
        $query = Testimoni::whereIn('status', ['verified', 'rejected']);

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->filled('jenis_bencana')) {
            $query->where('jenis_bencana', $request->jenis_bencana);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('lokasi', 'like', '%' . $request->search . '%')
                ->orWhere('jenis_bencana', 'like', '%' . $request->search . '%');
            });
        }

        $testimonis = $query->latest()->get();

        // Kirim data untuk dropdown unik
        $lokasiList = Testimoni::whereIn('status', ['verified', 'rejected'])->distinct()->pluck('lokasi');
        $jenisList = Testimoni::whereIn('status', ['verified', 'rejected'])->distinct()->pluck('jenis_bencana');

        return view('testimoni.index', compact('testimonis', 'lokasiList', 'jenisList'));
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
            'jenis_bencana' => $request->jenis_bencana === 'lainnya'
                ? $request->jenis_bencana_lain
                : $request->jenis_bencana,
            'isicerita' => $request->isicerita,
            'foto' => $fotoPath,
            'status' => 'pending',
        ]);

        return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil dikirim dan menunggu persetujuan admin.');
    }

    /**
     * Show pending testimonies for moderation.
     */
    public function moderation()
    {
        $testimonis = Testimoni::where('status', 'pending')->get();
        return view('admin.testimoni.moderation', compact('testimonis'));
    }

    /**
     * Approve a testimoni.
     */
    public function approve($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->status = 'verified';
        $testimoni->save();

        return redirect()->back()->with('success', 'Testimoni telah disetujui.');
    }

    /**
     * Reject a testimoni.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ]);

        $testimoni = Testimoni::findOrFail($id);
        $testimoni->status = 'rejected';
        $testimoni->alasan_penolakan = $request->alasan_penolakan;
        $testimoni->save();

        return redirect()->back()->with('success', 'Testimoni ditolak dengan alasan.');
    }

    public function show($id) 
    {
        $testimoni = Testimoni::findOrFail($id);
        return view('testimoni.show', compact('testimoni'));
    }
}
