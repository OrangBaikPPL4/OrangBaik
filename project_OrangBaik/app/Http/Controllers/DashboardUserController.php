<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestBantuan;

class DashboardUserController extends Controller
{
    public function index()
    {
        $requests = RequestBantuan::where('user_id', auth()->id())->get();
        
        return view('dashboard-user.dashboard', compact('requests'));
    }
}
