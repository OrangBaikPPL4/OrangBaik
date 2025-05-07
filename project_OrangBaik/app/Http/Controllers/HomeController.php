<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller // Sesuaikan modelnya
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
