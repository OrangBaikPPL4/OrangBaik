<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;
use Carbon\Carbon;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqData = [
            [
                'question' => 'Siapa saja yang bisa menjadi relawan?',
                'answer' => 'Siapa saja yang memiliki semangat membantu sesama dapat mendaftar sebagai relawan, baik individu maupun komunitas.',
                'created_at' => Carbon::now()->subDays(16),
            ],
            [
                'question' => 'Apakah saya bisa membuat program sosial sendiri di OrangBaik?',
                'answer' => 'Ya, kamu bisa mengajukan program sosial melalui dashboard setelah diverifikasi sebagai mitra organisasi sosial.',
                'created_at' => Carbon::now()->subDays(14),
            ],
            [
                'question' => 'Apakah donasi saya aman?',
                'answer' => 'Ya, seluruh transaksi di OrangBaik menggunakan sistem pembayaran yang aman dan setiap program telah melalui proses verifikasi.',
                'created_at' => Carbon::now()->subDays(12),
            ],
        ];

        foreach ($faqData as $data) {
            Faq::updateOrCreate(
                ['question' => $data['question']],
                [
                    'answer' => $data['answer'],
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['created_at'],
                ]
            );
        }
    }
}
