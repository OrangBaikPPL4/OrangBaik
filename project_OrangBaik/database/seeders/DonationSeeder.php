<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\User;
use App\Models\PaymentProof;
use App\Models\DonationStatusHistory;
use App\Models\Distribution;
use App\Models\DisasterReport;
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
        
        // Get disaster reports for linking to donations
        $disasterReports = DisasterReport::where('status', 'verified')->get();
        
        // Define donation data
        $donationData = [
            [
                'user_email' => 'rafif.kusuma@example.com',
                'amount' => 500000,
                'payment_method' => 'transfer_bank',
                'status' => 'confirmed',
                'transaction_id' => 'TRX001RAFI',
                'created_at' => Carbon::now()->subDays(30),
                'negara' => 'Indonesia',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'alamat_jalan' => 'Jl. Merdeka No. 123',
                'contact_phone' => '081234567890',
                'message' => 'Semoga bantuan ini bermanfaat untuk korban bencana',
                'proof_image' => '/images/payment_proofs/proof_rafif.jpg',
                'proof_notes' => 'Transfer dari Bank BCA'
            ],
            [
                'user_email' => 'budi.santoso@example.com',
                'amount' => 1000000,
                'payment_method' => 'transfer_bank',
                'status' => 'distributed',
                'transaction_id' => 'TRX002BUDI',
                'created_at' => Carbon::now()->subDays(25),
                'negara' => 'Indonesia',
                'provinsi' => 'DKI Jakarta',
                'kota' => 'Jakarta Selatan',
                'alamat_jalan' => 'Jl. Sudirman No. 45',
                'contact_phone' => '087654321098',
                'message' => 'Untuk korban banjir Jakarta',
                'proof_image' => '/images/payment_proofs/proof_budi.jpg',
                'proof_notes' => 'Transfer dari Bank Mandiri',
                'distribution_details' => [
                    'amount' => 1000000,
                    'disaster' => 'Banjir Jakarta',
                    'description' => 'Disalurkan untuk kebutuhan logistik korban banjir',
                    'proof_image' => '/images/distributions/dist_banjir_jakarta.jpg',
                    'distributed_at' => Carbon::now()->subDays(20)
                ]
            ],
            [
                'user_email' => 'citra.lestari@example.com',
                'amount' => 750000,
                'payment_method' => 'e_wallet',
                'status' => 'confirmed',
                'transaction_id' => 'TRX003CITR',
                'created_at' => Carbon::now()->subDays(20),
                'negara' => 'Indonesia',
                'provinsi' => 'Jawa Timur',
                'kota' => 'Surabaya',
                'alamat_jalan' => 'Jl. Pemuda No. 67',
                'contact_phone' => '085432109876',
                'message' => 'Semoga cepat pulih',
                'proof_image' => '/images/payment_proofs/proof_citra.jpg',
                'proof_notes' => 'Transfer dari GoPay'
            ],
            [
                'user_email' => 'dewi.anggraini@example.com',
                'amount' => 250000,
                'payment_method' => 'transfer_bank',
                'status' => 'pending',
                'transaction_id' => 'TRX004DEWI',
                'created_at' => Carbon::now()->subDays(15),
                'negara' => 'Indonesia',
                'provinsi' => 'DI Yogyakarta',
                'kota' => 'Yogyakarta',
                'alamat_jalan' => 'Jl. Malioboro No. 89',
                'contact_phone' => '081122334455',
                'message' => 'Semoga bermanfaat',
                'proof_image' => null,
                'proof_notes' => null
            ],
            [
                'user_email' => 'eko.prasetyo@example.com',
                'amount' => 1500000,
                'payment_method' => 'transfer_bank',
                'status' => 'distributed',
                'transaction_id' => 'TRX005EKOP',
                'created_at' => Carbon::now()->subDays(10),
                'negara' => 'Indonesia',
                'provinsi' => 'Jawa Tengah',
                'kota' => 'Semarang',
                'alamat_jalan' => 'Jl. Pahlawan No. 12',
                'contact_phone' => '082233445566',
                'message' => 'Untuk korban gempa',
                'proof_image' => '/images/payment_proofs/proof_eko.jpg',
                'proof_notes' => 'Transfer dari Bank BNI',
                'distribution_details' => [
                    'amount' => 1500000,
                    'disaster' => 'Gempa Garut',
                    'description' => 'Disalurkan untuk pembangunan hunian sementara',
                    'proof_image' => '/images/distributions/dist_gempa_garut.jpg',
                    'distributed_at' => Carbon::now()->subDays(5)
                ]
            ],
            [
                'user_email' => 'fira.maharani@example.com',
                'amount' => 300000,
                'payment_method' => 'e_wallet',
                'status' => 'confirmed',
                'transaction_id' => 'TRX006FIRA',
                'created_at' => Carbon::now()->subDays(5),
                'negara' => 'Indonesia',
                'provinsi' => 'Jawa Timur',
                'kota' => 'Malang',
                'alamat_jalan' => 'Jl. Ijen No. 34',
                'contact_phone' => '083344556677',
                'message' => 'Semoga bisa membantu',
                'proof_image' => '/images/payment_proofs/proof_fira.jpg',
                'proof_notes' => 'Transfer dari OVO'
            ],
            [
                'user_email' => 'gunawan.wibowo@example.com',
                'amount' => 500000,
                'payment_method' => 'transfer_bank',
                'status' => 'pending',
                'transaction_id' => 'TRX007GUNA',
                'created_at' => Carbon::now()->subDays(2),
                'negara' => 'Indonesia',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'alamat_jalan' => 'Jl. Dago No. 56',
                'contact_phone' => '084455667788',
                'message' => 'Untuk korban bencana',
                'proof_image' => null,
                'proof_notes' => null
            ],
        ];
        
        // Create donations with related data
        foreach ($donationData as $data) {
            if (isset($userIds[$data['user_email']])) {
                $userId = $userIds[$data['user_email']];
                
                // Assign a disaster report if available (for some donations)
                $disasterReportId = null;
                if ($disasterReports->count() > 0 && rand(0, 1) == 1) {
                    $disasterReportId = $disasterReports->random()->id;
                }
                
                // Create donation
                $donation = Donation::create([
                    'user_id' => $userId,
                    'amount' => $data['amount'],
                    'payment_method' => $data['payment_method'],
                    'status' => $data['status'],
                    'transaction_id' => $data['transaction_id'],
                    'contact_email' => $data['user_email'],
                    'contact_phone' => $data['contact_phone'],
                    'message' => $data['message'],
                    'negara' => $data['negara'],
                    'provinsi' => $data['provinsi'],
                    'kota' => $data['kota'],
                    'alamat_jalan' => $data['alamat_jalan'],
                    'disaster_report_id' => $disasterReportId,
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['created_at'],
                ]);
                
                // Create payment proof if available
                if ($data['proof_image']) {
                    PaymentProof::create([
                        'donation_id' => $donation->id,
                        'proof_image' => $data['proof_image'],
                        'notes' => $data['proof_notes'],
                        'created_at' => $data['created_at'],
                        'updated_at' => $data['created_at'],
                    ]);
                }
                
                // Create status history
                $adminId = User::where('usertype', 'admin')->first()->id ?? null;
                
                // Initial status (always 'pending')
                DonationStatusHistory::create([
                    'donation_id' => $donation->id,
                    'status' => 'pending',
                    'changed_by' => null, // System generated
                    'comment' => 'Donasi dibuat',
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['created_at'],
                ]);
                
                // If status is confirmed or distributed, add confirmed status history
                if (in_array($data['status'], ['confirmed', 'distributed'])) {
                    DonationStatusHistory::create([
                        'donation_id' => $donation->id,
                        'status' => 'confirmed',
                        'changed_by' => $adminId,
                        'comment' => 'Pembayaran telah dikonfirmasi',
                        'created_at' => $data['created_at']->addDays(1),
                        'updated_at' => $data['created_at']->addDays(1),
                    ]);
                }
                
                // If status is distributed, add distributed status history and distribution record
                if ($data['status'] === 'distributed' && isset($data['distribution_details'])) {
                    DonationStatusHistory::create([
                        'donation_id' => $donation->id,
                        'status' => 'distributed',
                        'changed_by' => $adminId,
                        'comment' => 'Donasi telah disalurkan',
                        'created_at' => $data['distribution_details']['distributed_at'],
                        'updated_at' => $data['distribution_details']['distributed_at'],
                    ]);
                    
                    Distribution::create([
                        'donation_id' => $donation->id,
                        'amount' => $data['distribution_details']['amount'],
                        'disaster' => $data['distribution_details']['disaster'],
                        'description' => $data['distribution_details']['description'],
                        'proof_image' => $data['distribution_details']['proof_image'],
                        'distributed_at' => $data['distribution_details']['distributed_at'],
                        'created_at' => $data['distribution_details']['distributed_at'],
                        'updated_at' => $data['distribution_details']['distributed_at'],
                    ]);
                }
            }
        }
    }
}
