<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DisasterReport;

class DisasterReportController extends Controller
{
    public function index()
    {
        // Ambil semua laporan bencana dengan relasi user (pelapor)
        $reports = DisasterReport::with('user')->latest()->get();

        return view('admin.disaster-reports.index', compact('reports'));
    }

    public function show($id)
    {
    $report = DisasterReport::with('user')->findOrFail($id);
    return view('admin.disaster-reports.show', compact('report'));
    }

    public function verify(Request $request, $id)
    {
    $request->validate([
    'status' => 'required|in:pending,verified,rejected',
    ]);

    $report = \App\Models\DisasterReport::findOrFail($id);
    $report->status = $request->input('status');
    $report->save();

    return redirect()
        ->route('admin.disaster_reports.show', $report->id)
        ->with('success', 'Status laporan berhasil diperbarui.');
    }
}
