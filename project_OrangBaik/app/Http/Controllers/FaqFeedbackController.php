<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqFeedback;

class FaqFeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        FaqFeedback::create([
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas masukannya!');
    }
}
