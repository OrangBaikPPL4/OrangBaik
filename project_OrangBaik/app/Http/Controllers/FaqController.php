<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->usertype === 'admin') {
            return redirect()->route('admin.faq.index');
        }

        $faqs = Faq::all();
        return view('faq.index', compact('faqs'));
    }
}

