<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Notifications\DonationStatusUpdated;
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
        $donation->load(['user', 'paymentProof', 'statusHistories.admin']);
        if (!$donation) {
            abort(404, 'Donasi tidak ditemukan.');
        }
        return view('admin.donations.show', compact('donation'));
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,failed,distributed',
            'comment' => 'nullable|string|max:1000',
        ]);

        $donation->update(['status' => $validated['status']]);
        
        // Log status change
        \App\Models\DonationStatusHistory::create([
            'donation_id' => $donation->id,
            'status' => $validated['status'],
            'changed_by' => auth()->id(),
            'comment' => $request->input('comment'),
        ]);
        
        // Send notification to user
        if ($donation->user) {
            $donation->user->notify(new \App\Notifications\DonationStatusUpdated($donation, $validated['comment'] ?? null));
        }
        
        return redirect()->back()->with('success', 'Status donasi berhasil diperbarui.');
    }

    public function edit(Donation $donation)
    {
        $donation->load(['user', 'paymentProof']);
        return view('admin.donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:bank_transfer,e_wallet',
            'status' => 'required|in:pending,confirmed,failed,distributed',
            'message' => 'nullable|string|max:500',
        ]);
        $donation->update($validated);
        return redirect()->route('admin.donations.show', $donation->id)->with('success', 'Donasi berhasil diperbarui.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Donasi berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        Donation::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', 'Donasi terpilih berhasil dihapus.');
    }
} 