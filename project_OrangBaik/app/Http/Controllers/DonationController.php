<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\PaymentProof;
use App\Notifications\DonationConfirmed;
use App\Notifications\PaymentProofUploaded;
use App\Notifications\WhatsAppPaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donations = Donation::with('user', 'paymentProof')
            ->latest()
            ->paginate(10);
            
        return view('donations.index', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('donations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'negara' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'alamat_jalan' => 'required|string|max:255',
            'amount' => 'required|numeric|min:20000',
            'payment_method' => 'required|in:bank_transfer,e_wallet',
            'contact_email' => 'required_without:contact_phone|email|nullable',
            'contact_phone' => 'required_without:contact_email|string|nullable',
            'message' => 'nullable|string|max:500',
        ], [
            'negara.required' => 'Negara harus diisi',
            'provinsi.required' => 'Provinsi harus dipilih',
            'kota.required' => 'Kota/Kabupaten harus dipilih',
            'alamat_jalan.required' => 'Alamat jalan harus diisi',
            'amount.min' => 'Jumlah donasi minimal Rp 20.000',
            'amount.required' => 'Jumlah donasi harus diisi',
            'payment_method.required' => 'Metode pembayaran harus dipilih',
            'payment_method.in' => 'Metode pembayaran tidak valid',
            'contact_email.required_without' => 'Email atau nomor telepon harus diisi',
            'contact_email.email' => 'Format email tidak valid',
            'contact_phone.required_without' => 'Email atau nomor telepon harus diisi',
        ]);

        try {
            $donation = Donation::create([
                'user_id' => auth()->id(),
                'negara' => $validated['negara'],
                'provinsi' => $validated['provinsi'],
                'kota' => $validated['kota'],
                'alamat_jalan' => $validated['alamat_jalan'],
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'],
                'message' => $validated['message'],
                'transaction_id' => 'DON-' . Str::random(10),
                'status' => 'pending'
            ]);

            return redirect()->route('donations.show', $donation)
                ->with('success', 'Donasi berhasil dibuat. Silakan unggah bukti pembayaran Anda.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat donasi. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        $user = auth()->user();

        // If the donation is associated with a specific user (i.e., not an anonymous donation)
        if ($donation->user_id !== null) {
            // Check if the current user is authorized:
            // - They must be authenticated.
            // - AND (EITHER they are an admin OR they are the owner of the donation).
            // If not authorized, abort with 403.
            if (!$user || ($user->usertype !== 'admin' && $donation->user_id !== $user->id)) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        }
        // If $donation->user_id is null (anonymous donation), or if the user is authorized,
        // proceed to show the donation.

        return view('donations.show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function uploadProof(Request $request, Donation $donation)
    {
        $request->validate([
            'proof_image' => 'required|image|max:2048',
            'notes' => 'nullable|string|max:500'
        ]);

        $path = $request->file('proof_image')->store('payment-proofs', 'public');

        $donation->paymentProof()->create([
            'proof_image' => $path,
            'notes' => $request->notes
        ]);

        return redirect()->route('donations.show', $donation)
            ->with('success', 'Payment proof uploaded successfully. Please wait for admin verification.');
    }

    public function confirm(Donation $donation)
    {
        $donation->update(['status' => 'confirmed']);

        // Send notification
        if ($donation->user) {
            $donation->user->notify(new DonationConfirmed($donation));
        } else {
            // For anonymous donors, send to their email or phone
            if ($donation->contact_email) {
                \Notification::route('mail', $donation->contact_email)
                    ->notify(new DonationConfirmed($donation));
            }
            if ($donation->contact_phone) {
                \Notification::route('vonage', $donation->contact_phone)
                    ->notify(new DonationConfirmed($donation));
            }
        }

        return redirect()->route('donations.show', $donation)
            ->with('success', 'Donation confirmed successfully.');
    }

    public function reject(Donation $donation)
    {
        $donation->update(['status' => 'failed']);
        
        return redirect()->route('donations.show', $donation)
            ->with('success', 'Donation marked as failed.');
    }

    public function storePaymentProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $donation = Donation::findOrFail($id);
        
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $donation->payment_proof = $path;
            $donation->status = 'pending';
            $donation->save();

            try {
                // Send WhatsApp notification
                $donation->user->notify(new WhatsAppPaymentProof($donation));

                return redirect()->route('donations.show', $donation->id)
                    ->with('success', 'Bukti pembayaran berhasil diunggah. Notifikasi WhatsApp telah dikirim.');
            } catch (\Exception $e) {
                Log::error('Failed to send WhatsApp notification', [
                    'donation_id' => $donation->id,
                    'error' => $e->getMessage()
                ]);

                return back()->with('error', 'Bukti pembayaran berhasil diunggah, tetapi notifikasi WhatsApp gagal dikirim.');
            }
        }

        return back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }
}
