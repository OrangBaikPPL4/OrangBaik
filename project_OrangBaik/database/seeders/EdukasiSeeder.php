<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Edukasi; // Make sure this is the correct namespace for your Edukasi model
// Removed: use Illuminate\Support\Str; as 'slug' is not used.
// Removed: use Carbon\Carbon; as 'published_at' is not used.

class EdukasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Edukasi::updateOrCreate(
            ['title' => 'Kesiapsiagaan Menghadapi Gempa Bumi'],
            [
                // 'slug' => Str::slug('Kesiapsiagaan Menghadapi Gempa Bumi'), // Removed
                'category' => 'Gempa Bumi',
                'content' => '<p>Gempa bumi adalah getaran atau guncangan yang terjadi di permukaan bumi akibat pelepasan energi dari bawah permukaan secara tiba-tiba yang menciptakan gelombang seismik. Berikut adalah langkah-langkah kesiapsiagaan yang dapat Anda lakukan:</p><ul><li>Kenali lingkungan tempat Anda bekerja dan tinggal.</li><li>Perhatikan letak pintu, lift, serta tangga darurat.</li><li>Belajar melakukan P3K dan cara menggunakan alat pemadam kebakaran.</li><li>Catat nomor telepon penting yang dapat dihubungi pada saat terjadi gempa bumi.</li><li>Siapkan tas siaga bencana.</li></ul>',
                'image' => '/images/edukasi_examples/gempa_bumi.jpg', // Changed from image_url
                // 'author' => 'Tim OrangBaik', // Removed
                // 'published_at' => now(), // Removed
                // Add video_file or video_link if you have sample data for them
                // 'video_link' => 'https://www.youtube.com/watch?v=examplevideo1',
            ]
        );

        Edukasi::updateOrCreate(
            ['title' => 'Langkah Antisipasi Banjir Saat Musim Hujan'],
            [
                // 'slug' => Str::slug('Langkah Antisipasi Banjir Saat Musim Hujan'), // Removed
                'category' => 'Banjir',
                'content' => '<p>Banjir merupakan bencana alam yang sering terjadi di Indonesia, terutama saat musim hujan. Berikut beberapa langkah antisipasi yang bisa dilakukan:</p><ol><li>Bersihkan saluran air dan selokan di sekitar rumah.</li><li>Buat lubang resapan biopori.</li><li>Tinggikan pondasi rumah jika berada di daerah rawan banjir.</li><li>Amankan dokumen penting di tempat yang tinggi dan kedap air.</li><li>Siapkan perbekalan darurat seperti makanan instan, air minum, obat-obatan, dan senter.</li></ol>',
                'image' => '/images/edukasi_examples/banjir.jpg', // Changed from image_url
                // 'author' => 'Pakar Hidrologi Unpad', // Removed
                // 'published_at' => now()->subDays(5), // Removed
            ]
        );

        Edukasi::updateOrCreate(
            ['title' => 'Mengenal Tanda-Tanda Akan Terjadinya Tsunami'],
            [
                // 'slug' => Str::slug('Mengenal Tanda-Tanda Akan Terjadinya Tsunami'), // Removed
                'category' => 'Tsunami',
                'content' => '<p>Tsunami dapat disebabkan oleh gempa bumi bawah laut, letusan gunung berapi, atau longsoran bawah laut. Kenali tanda-tandanya:</p><ul><li>Gempa bumi kuat yang terasa di daerah pantai.</li><li>Air laut surut secara tiba-tiba dan drastis.</li><li>Terdengar suara gemuruh dari arah laut.</li><li>Munculnya gelombang besar yang mendekat ke pantai.</li></ul><p>Jika Anda melihat tanda-tanda ini, segera evakuasi ke tempat yang lebih tinggi dan aman.</p>',
                'image' => '/images/edukasi_examples/tsunami.jpg', // Changed from image_url
                // 'author' => 'BMKG Pusat', // Removed
                // 'published_at' => now()->subDays(10), // Removed
            ]
        );
    }
}