<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with(['user', 'paymentProof'])
            ->latest()
            ->paginate(20);

        return view('admin.donations.index', compact('donations'));
    }

    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,failed'
        ]);

        $donation->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status donasi berhasil diperbarui.');
    }
} 