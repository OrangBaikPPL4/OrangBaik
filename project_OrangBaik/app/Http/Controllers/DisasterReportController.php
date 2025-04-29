<?php

namespace App\Http\Controllers;

use App\Models\DisasterReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DisasterReportController extends Controller
{
    public function index()
    {
    $disasterReports = DisasterReport::latest()->get(); // Ambil semua laporan bencana dari database, urutkan dari yang terbaru

    return view('disaster_report.index', compact('disasterReports'));
    }

    // Menampilkan form laporan bencana
    public function create()
    {
        return view('disaster_report.create'); // Update view sesuai dengan nama folder dan file view
    }

    public function show($id)
    {
    $report = DisasterReport::findOrFail($id);

    return view('disaster_report.show', compact('report'));
    }

    // Menyimpan laporan bencana
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'lokasi' => 'required|string|max:255',
            'jenis_bencana' => 'required|in:banjir,gempa,kebakaran,longsor,lainnya',
            'deskripsi' => 'required|string',
            'bukti_media' => 'nullable|array',
            'bukti_media.*' => 'mimes:jpg,jpeg,png,mp4|max:10240', // Maksimal 10MB
        ]);

        // Membuat instance DisasterReport baru
        $disasterReport = new DisasterReport();
        $disasterReport->user_id = Auth::id(); // Menyimpan ID pengguna yang login
        $disasterReport->lokasi = $validatedData['lokasi'];
        $disasterReport->jenis_bencana = $validatedData['jenis_bencana'];
        $disasterReport->deskripsi = $validatedData['deskripsi'];

        // Menyimpan bukti media jika ada
        if ($request->hasFile('bukti_media')) {
            $media = [];
            foreach ($request->file('bukti_media') as $file) {
                // Menyimpan file dan mendapatkan path-nya
                $path = $file->store('bukti_bencana', 'public'); // Di dalam folder storage/app/public/bukti_bencana
                $media[] = $path;
            }
            $disasterReport->bukti_media = json_encode($media); // Menyimpan path media dalam format JSON
        }

        // Menyimpan laporan ke database
        $disasterReport->save();

        // Mengarahkan kembali ke daftar laporan dengan pesan sukses
        return redirect()->route('disaster_report.index')->with('success', 'Laporan bencana berhasil dikirim!');
    }
}
