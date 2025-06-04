<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;
use Carbon\Carbon;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define FAQ data - only 3 essential FAQs
        $faqData = [
            [
                'question' => 'Apa itu OrangBaik?',
                'answer' => 'OrangBaik adalah platform digital berbasis web yang bertujuan untuk meningkatkan efektivitas dan efisiensi penanganan bencana alam, khususnya di Jawa Barat. Platform ini menghubungkan korban bencana, relawan, dan donatur untuk koordinasi bantuan yang lebih baik, transparansi distribusi, dan penyediaan informasi terkini.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'question' => 'Apa perbedaan antara Misi Bantuan dan Acara Volunteer?',
                'answer' => 'Misi Bantuan adalah kegiatan yang bersifat darurat dan reaktif untuk merespons bencana alam mendadak seperti gempa, banjir, atau kebakaran hutan. Fokusnya pada penyelamatan dan kebutuhan darurat. Sedangkan Acara Volunteer adalah kegiatan kerelawanan yang terencana dan terstruktur seperti bersih pantai, acara sosial, atau penggalangan dana terencana.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'question' => 'Bagaimana cara menjadi relawan di OrangBaik?',
                'answer' => 'Untuk menjadi relawan di OrangBaik, Anda perlu mendaftar akun terlebih dahulu, kemudian mengisi formulir pendaftaran relawan dengan data diri lengkap. Setelah itu, admin akan memverifikasi data Anda dan mengubah status menjadi "approved" jika memenuhi syarat. Setelah disetujui, Anda dapat bergabung dengan misi bantuan atau acara volunteer yang tersedia.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Create FAQs
        foreach ($faqData as $data) {
            Faq::create([
                'question' => $data['question'],
                'answer' => $data['answer'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }
    }
}
