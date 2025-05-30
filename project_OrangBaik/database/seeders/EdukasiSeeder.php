<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Edukasi;
use Carbon\Carbon;

class EdukasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edukasiData = [
            [
                'title' => 'Kesiapsiagaan Menghadapi Gempa Bumi',
                'category' => 'Gempa Bumi',
                'content' => '<p>Gempa bumi adalah getaran atau guncangan yang terjadi di permukaan bumi akibat pelepasan energi dari bawah permukaan secara tiba-tiba yang menciptakan gelombang seismik. Berikut adalah langkah-langkah kesiapsiagaan yang dapat Anda lakukan:</p><ul><li>Kenali lingkungan tempat Anda bekerja dan tinggal.</li><li>Perhatikan letak pintu, lift, serta tangga darurat.</li><li>Belajar melakukan P3K dan cara menggunakan alat pemadam kebakaran.</li><li>Catat nomor telepon penting yang dapat dihubungi pada saat terjadi gempa bumi.</li><li>Siapkan tas siaga bencana.</li></ul>',
                'image' => '/images/edukasi_examples/gempa_bumi.jpg',
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'title' => 'Langkah Antisipasi Banjir Saat Musim Hujan',
                'category' => 'Banjir',
                'content' => '<p>Banjir merupakan bencana alam yang sering terjadi di Indonesia, terutama saat musim hujan. Berikut beberapa langkah antisipasi yang bisa dilakukan:</p><ol><li>Bersihkan saluran air dan selokan di sekitar rumah.</li><li>Buat lubang resapan biopori.</li><li>Tinggikan pondasi rumah jika berada di daerah rawan banjir.</li><li>Amankan dokumen penting di tempat yang tinggi dan kedap air.</li><li>Siapkan perbekalan darurat seperti makanan instan, air minum, obat-obatan, dan senter.</li></ol>',
                'image' => '/images/edukasi_examples/banjir.jpg',
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'title' => 'Mengenal Tanda-Tanda Akan Terjadinya Tsunami',
                'category' => 'Tsunami',
                'content' => '<p>Tsunami dapat disebabkan oleh gempa bumi bawah laut, letusan gunung berapi, atau longsoran bawah laut. Kenali tanda-tandanya:</p><ul><li>Gempa bumi kuat yang terasa di daerah pantai.</li><li>Air laut surut secara tiba-tiba dan drastis.</li><li>Terdengar suara gemuruh dari arah laut.</li><li>Munculnya gelombang besar yang mendekat ke pantai.</li></ul><p>Jika Anda melihat tanda-tanda ini, segera evakuasi ke tempat yang lebih tinggi dan aman.</p>',
                'image' => '/images/edukasi_examples/tsunami.jpg',
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Cara Menyelamatkan Diri dari Kebakaran Gedung',
                'category' => 'Kebakaran',
                'content' => '<p>Kebakaran gedung dapat terjadi kapan saja dan menyebar dengan cepat. Berikut langkah-langkah penyelamatan diri:</p><ol><li>Jangan panik dan tetap tenang.</li><li>Segera menuju pintu keluar atau tangga darurat. Jangan gunakan lift.</li><li>Bergeraklah dengan merangkak jika ada asap tebal.</li><li>Tutup hidung dan mulut dengan kain basah.</li><li>Jangan kembali ke dalam gedung untuk mengambil barang.</li><li>Hubungi pemadam kebakaran di nomor 113.</li></ol>',
                'image' => '/images/edukasi_examples/kebakaran_gedung.jpg',
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Pertolongan Pertama pada Korban Bencana',
                'category' => 'P3K',
                'content' => '<p>Pertolongan pertama yang tepat dapat menyelamatkan nyawa korban bencana. Berikut panduan dasar yang perlu diketahui:</p><ul><li><strong>Luka Terbuka:</strong> Bersihkan dengan air bersih, tutup dengan kain bersih, dan tekan untuk menghentikan pendarahan.</li><li><strong>Patah Tulang:</strong> Jangan memindahkan korban kecuali dalam bahaya. Stabilkan area yang patah dengan bidai improvisasi.</li><li><strong>Luka Bakar:</strong> Dinginkan dengan air bersih selama 10-15 menit. Jangan gunakan es atau mentega.</li><li><strong>Tersedak:</strong> Lakukan manuver Heimlich dengan mendorong perut ke dalam dan ke atas.</li><li><strong>Henti Jantung:</strong> Lakukan CPR dengan 30 kompresi dada diikuti 2 napas buatan.</li></ul>',
                'image' => '/images/edukasi_examples/p3k_bencana.jpg',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Menyiapkan Tas Siaga Bencana',
                'category' => 'Kesiapsiagaan',
                'content' => '<p>Tas siaga bencana adalah perlengkapan penting yang harus disiapkan setiap keluarga. Berikut isi yang direkomendasikan:</p><ul><li>Air minum untuk 3 hari (3 liter per orang per hari)</li><li>Makanan tahan lama untuk 3 hari</li><li>Kotak P3K dan obat-obatan rutin</li><li>Senter dan baterai cadangan</li><li>Radio portable bertenaga baterai</li><li>Peluit untuk menarik perhatian</li><li>Masker debu dan sarung tangan tebal</li><li>Selimut darurat</li><li>Dokumen penting dalam wadah kedap air</li><li>Uang tunai dalam pecahan kecil</li><li>Peta lokal</li><li>Ponsel dan charger portable</li></ul>',
                'image' => '/images/edukasi_examples/tas_siaga.jpg',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Evakuasi Mandiri saat Terjadi Letusan Gunung Berapi',
                'category' => 'Gunung Berapi',
                'content' => '<p>Letusan gunung berapi dapat menimbulkan berbagai bahaya seperti awan panas, hujan abu, lahar, dan gas beracun. Berikut panduan evakuasi mandiri:</p><ol><li>Perhatikan informasi status gunung dari PVMBG.</li><li>Siapkan masker, kacamata pelindung, dan pakaian lengan panjang.</li><li>Saat diperintahkan evakuasi, segera tinggalkan rumah menuju titik kumpul.</li><li>Hindari lembah dan aliran sungai yang berhulu di gunung berapi.</li><li>Bawa tas siaga bencana yang telah disiapkan.</li><li>Ikuti arahan petugas dan jangan kembali ke rumah sebelum dinyatakan aman.</li></ol>',
                'image' => '/images/edukasi_examples/gunung_berapi.jpg',
                'created_at' => Carbon::now()->subDays(2),
            ],
        ];
        
        foreach ($edukasiData as $data) {
            Edukasi::updateOrCreate(
                ['title' => $data['title']],
                [
                    'category' => $data['category'],
                    'content' => $data['content'],
                    'image' => $data['image'],
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['created_at'],
                ]
            );
        }
    }
}