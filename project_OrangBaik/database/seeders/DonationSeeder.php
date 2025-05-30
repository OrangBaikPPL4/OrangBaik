<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\User;
use Carbon\Carbon;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for creating donations
        $users = [
            'rafif.kusuma@example.com',
            'budi.santoso@example.com',
            'citra.lestari@example.com',
            'dewi.anggraini@example.com',
            'eko.prasetyo@example.com',
            'fira.maharani@example.com',
            'gunawan.wibowo@example.com',
        ];
        
        $userIds = [];
        foreach ($users as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $userIds[$email] = $user->id;
            }
        }
        
        // Define donation data
        $donationData = [
            [
                'user_email' => 'rafif.kusuma@example.com',
                'amount' => 500000,
                'payment_method' => 'transfer_bank',
                'status' => 'confirmed',
                'transaction_id' => 'TRX001RAFI',
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'user_email' => 'budi.santoso@example.com',
                'amount' => 1000000,
                'payment_method' => 'transfer_bank',
                'status' => 'confirmed',
                'transaction_id' => 'TRX002BUDI',
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'user_email' => 'citra.lestari@example.com',
                'amount' => 750000,
                'payment_method' => 'e_wallet',
                'status' => 'confirmed',
                'transaction_id' => 'TRX003CITR',
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'user_email' => 'dewi.anggraini@example.com',
                'amount' => 250000,
                'payment_method' => 'transfer_bank',
                'status' => 'pending',
                'transaction_id' => 'TRX004DEWI',
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'user_email' => 'eko.prasetyo@example.com',
                'amount' => 1500000,
                'payment_method' => 'transfer_bank',
                'status' => 'confirmed',
                'transaction_id' => 'TRX005EKOP',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_email' => 'fira.maharani@example.com',
                'amount' => 300000,
                'payment_method' => 'e_wallet',
                'status' => 'confirmed',
                'transaction_id' => 'TRX006FIRA',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_email' => 'gunawan.wibowo@example.com',
                'amount' => 500000,
                'payment_method' => 'transfer_bank',
                'status' => 'pending',
                'transaction_id' => 'TRX007GUNA',
                'created_at' => Carbon::now()->subDays(2),
            ],
        ];
        
        // Create donations
        foreach ($donationData as $data) {
            if (isset($userIds[$data['user_email']])) {
                $userId = $userIds[$data['user_email']];
                
                Donation::create([
                    'user_id' => $userId,
                    'amount' => $data['amount'],
                    'payment_method' => $data['payment_method'],
                    'status' => $data['status'],
                    'transaction_id' => $data['transaction_id'],
                    'contact_email' => $data['user_email'], // Assuming donor email is contact email
                    'contact_phone' => null, // Add dummy phone if needed
                    'message' => 'Donation from seeder',
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['created_at'],
                ]);
            }
        }
    }
}
