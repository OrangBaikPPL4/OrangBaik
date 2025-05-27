<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqFeedback;

class FaqFeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_email' => 'nullable|email|max:255',
            'feedback' => 'required|string|max:1000',
        ]);

        $email = $request->input('user_email');
        if (empty($email) && auth()->check()) {
            $email = auth()->user()->email;
        }

        FaqFeedback::create([
            'user_email' => $email,
            'message' => $request->feedback, // Sesuai dengan nama kolom di memori
            // 'is_addressed' akan default ke false (atau nilai default DB)
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas masukannya!');
    }
}
