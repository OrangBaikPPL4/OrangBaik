<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestBantuan; // ganti sesuai nama Model kamu

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil status dari query URL, misal /dashboard-admin?status=pending
        $status = $request->query('status');

        if ($status) {
            $requests = RequestBantuan::where('status', $status)->get();
        } else {
            $requests = RequestBantuan::all(); // kalau tidak pilih status, tampilkan semua
        }

        return view('admin.dashboard', compact('requests', 'status'));
    }
}
