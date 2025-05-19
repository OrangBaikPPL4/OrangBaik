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
}
