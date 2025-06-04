<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimoni;
use Carbon\Carbon;

class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonis = [
            [
                'nama' => 'Ahmad Rizki',
                'lokasi' => 'Yogyakarta',
                'jenis_bencana' => 'Gempa Bumi',
                'isicerita' => 'Saya sangat berterima kasih kepada OrangBaik yang telah memberikan bantuan cepat saat gempa melanda Yogyakarta. Relawan datang dengan bantuan logistik dan medis yang sangat dibutuhkan oleh warga di pengungsian. Semoga kebaikan ini terus berlanjut untuk membantu korban bencana lainnya.',
                'foto' => 'images/testimoni/testimoni1.jpg',
                'status' => 'verified',
                'alasan_penolakan' => null,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(29),
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'lokasi' => 'Aceh',
                'jenis_bencana' => 'Banjir',
                'isicerita' => 'Banjir besar melanda kampung kami dan OrangBaik adalah salah satu organisasi pertama yang datang membantu. Mereka tidak hanya memberikan bantuan makanan dan pakaian, tetapi juga membantu membersihkan rumah-rumah warga yang terdampak. Terima kasih atas dedikasi para relawan!',
                'foto' => 'images/testimoni/testimoni2.jpg',
                'status' => 'verified',
                'alasan_penolakan' => null,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(24),
            ],
            [
                'nama' => 'Budi Santoso',
                'lokasi' => 'Palu',
                'jenis_bencana' => 'Tsunami',
                'isicerita' => 'Pasca tsunami yang menghancurkan sebagian besar kota kami, OrangBaik hadir dengan program rehabilitasi jangka panjang. Mereka membantu membangun kembali rumah kami dan memberikan pelatihan keterampilan agar kami bisa bangkit kembali. Semangat kemanusiaan yang luar biasa!',
                'foto' => 'images/testimoni/testimoni3.jpg',
                'status' => 'verified',
                'alasan_penolakan' => null,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(19),
            ],
            [
                'nama' => 'Dewi Lestari',
                'lokasi' => 'Lombok',
                'jenis_bencana' => 'Gempa Bumi',
                'isicerita' => 'Gempa Lombok meninggalkan trauma mendalam bagi kami. OrangBaik tidak hanya memberikan bantuan fisik tetapi juga pendampingan psikologis yang sangat membantu pemulihan mental warga, terutama anak-anak. Terima kasih telah menjadi bagian dari proses pemulihan kami.',
                'foto' => 'images/testimoni/testimoni4.jpg',
                'status' => 'pending',
                'alasan_penolakan' => null,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'nama' => 'Hendra Wijaya',
                'lokasi' => 'Kalimantan Timur',
                'jenis_bencana' => 'Kebakaran Hutan',
                'isicerita' => 'Saat kebakaran hutan melanda desa kami, OrangBaik mengirimkan tim relawan yang membantu evakuasi dan memberikan masker serta obat-obatan. Mereka juga mengadakan kampanye penggalangan dana untuk membantu warga yang kehilangan mata pencaharian.',
                'foto' => 'images/testimoni/testimoni5.jpg',
                'status' => 'rejected',
                'alasan_penolakan' => 'Informasi tidak lengkap dan tidak dapat diverifikasi',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(8),
            ],
        ];

        foreach ($testimonis as $testimoni) {
            Testimoni::create($testimoni);
        }
    }
}
