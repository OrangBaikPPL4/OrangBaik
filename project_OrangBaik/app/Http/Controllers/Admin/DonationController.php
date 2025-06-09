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
        $disasters = \App\Models\DisasterReport::all();
        return view('admin.donations.index', compact('donations', 'disasters'));
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

    public function distribute(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'disaster_report_id' => 'required|exists:disaster_reports,id',
            'amount' => 'required|numeric|min:0|max:' . $donation->amount,
            'description' => 'required|string|max:1000',
            'proof_image' => 'required|image|max:2048',
        ]);

        // Store the proof image
        $proofPath = $request->file('proof_image')->store('distribution-proofs', 'public');

        // Fetch the selected disaster report
        $disasterReport = \App\Models\DisasterReport::find($validated['disaster_report_id']);

        // Create distribution record
        $distribution = \App\Models\Distribution::create([
            'donation_id' => $donation->id,
            'amount' => $validated['amount'],
            'disaster' => $disasterReport ? $disasterReport->jenis_bencana : null,
            'description' => $validated['description'],
            'proof_image' => $proofPath,
            'distributed_at' => now(),
        ]);

        // Update donation status
        $donation->disaster_report_id = $validated['disaster_report_id'];
        $donation->status = 'distributed';
        $donation->save();

        // Log status change
        \App\Models\DonationStatusHistory::create([
            'donation_id' => $donation->id,
            'status' => 'distributed',
            'changed_by' => auth()->id(),
            'comment' => 'Donasi didistribusikan ke bencana: ' . ($disasterReport ? $disasterReport->jenis_bencana : '-')
        ]);

        // Notify user
        if ($donation->user) {
            try {
                $donation->user->notify(new \App\Notifications\DonationDistributed($donation));
            } catch (\Exception $e) {
                \Log::error('Failed to send distribution notification: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donasi berhasil didistribusikan.');
    }
} 