<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Volunteer;
use App\Models\VolunteerEventRole;
use App\Models\Relawan;
use App\Models\User;
use Carbon\Carbon;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Relawan
        $relawanRafif = Relawan::whereHas('user', fn ($query) => $query->where('email', 'rafif.kusuma@example.com'))->first();
        $relawanBudi = Relawan::whereHas('user', fn ($query) => $query->where('email', 'budi.santoso@example.com'))->first();
        $relawanCitra = Relawan::whereHas('user', fn ($query) => $query->where('email', 'citra.lestari@example.com'))->first();

        // --- Event 1: Bersih Pantai ---
        $event1 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Aksi Bersih Pantai Cilacap'],
            [
                'deskripsi' => 'Bergabunglah dengan kami dalam membersihkan Pantai Cilacap dari sampah plastik dan lainnya untuk menjaga keindahan dan kelestarian lingkungan laut.',
                'lokasi' => 'Pantai Teluk Penyu, Cilacap',
                'tanggal_mulai' => Carbon::now()->addDays(10),
                'tanggal_selesai' => Carbon::now()->addDays(10)->addHours(5),
                'status' => 'aktif', // aktif, dalam_proses, selesai, ditunda, dibatalkan
                'kuota_relawan' => 50,
                'image_url' => '/images/volunteer_examples/bersih_pantai.jpg', // Example image path
            ]
        );

        if ($event1) {
            $role1_1 = $event1->roles()->updateOrCreate(
                ['name' => 'Koordinator Lapangan'],
                [
                    'description' => 'Mengkoordinasikan relawan di area spesifik.',
                    'slots_needed' => 2,
                    'estimated_work_hours' => 5
                ]
            );
            $role1_2 = $event1->roles()->updateOrCreate(
                ['name' => 'Pengumpul Sampah'],
                [
                    'description' => 'Mengumpulkan sampah dari area pantai.',
                    'slots_needed' => 40,
                    'estimated_work_hours' => 4
                ]
            );
            $role1_3 = $event1->roles()->updateOrCreate(
                ['name' => 'Dokumentasi'],
                [
                    'description' => 'Mendokumentasikan kegiatan.',
                    'slots_needed' => 3,
                    'estimated_work_hours' => 5
                ]
            );

            // Assign relawan to Event 1
            if ($relawanRafif) {
                $event1->relawan()->syncWithoutDetaching([
                    $relawanRafif->id => [
                        'status_partisipasi' => 'disetujui',
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $role1_1->id, // Rafif as Koordinator
                        'created_at' => now(), 'updated_at' => now()
                    ]
                ]);
            }
            if ($relawanBudi) {
                $event1->relawan()->syncWithoutDetaching([
                    $relawanBudi->id => [
                        'status_partisipasi' => 'menunggu',
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $role1_2->id, // Budi as Pengumpul Sampah
                        'created_at' => now(), 'updated_at' => now()
                    ]
                ]);
            }
        }

        // --- Event 2: Penggalangan Dana Bencana ---
        $event2 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Galang Dana untuk Korban Banjir Garut'],
            [
                'deskripsi' => 'Mari bantu saudara kita yang terdampak banjir di Garut dengan menggalang dana untuk kebutuhan mendesak mereka.',
                'lokasi' => 'Online & Posko Bantuan Bandung',
                'tanggal_mulai' => Carbon::now()->addDays(5),
                'tanggal_selesai' => Carbon::now()->addDays(25),
                'status' => 'aktif',
                'kuota_relawan' => 30,
                'image_url' => '/images/volunteer_examples/galang_dana.jpg',
            ]
        );

        if ($event2) {
            $role2_1 = $event2->roles()->updateOrCreate(
                ['name' => 'Koordinator Donasi Online'],
                ['description' => 'Mengelola kampanye donasi online.', 'slots_needed' => 5, 'estimated_work_hours' => 0] // 0 for ongoing
            );
            $role2_2 = $event2->roles()->updateOrCreate(
                ['name' => 'Petugas Posko Bantuan'],
                ['description' => 'Menerima dan menyalurkan bantuan di posko.', 'slots_needed' => 10, 'estimated_work_hours' => 6]
            );

            if ($relawanCitra) {
                $event2->relawan()->syncWithoutDetaching([
                    $relawanCitra->id => [
                        'status_partisipasi' => 'disetujui',
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $role2_1->id,
                        'created_at' => now(), 'updated_at' => now()
                    ]
                ]);
            }
             if ($relawanBudi) { // Budi joins another event
                $event2->relawan()->syncWithoutDetaching([
                    $relawanBudi->id => [
                        'status_partisipasi' => 'disetujui',
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $role2_2->id,
                        'created_at' => now(), 'updated_at' => now()
                    ]
                ]);
            }
        }

        // --- Event 3: Edukasi Mitigasi Bencana (Status Selesai) ---
        $event3 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Workshop Kesiapsiagaan Bencana Gempa'],
            [
                'deskripsi' => 'Workshop untuk meningkatkan pemahaman masyarakat tentang mitigasi dan kesiapsiagaan menghadapi bencana gempa bumi.',
                'lokasi' => 'Aula Kecamatan Sukajadi, Bandung',
                'tanggal_mulai' => Carbon::now()->subDays(30),
                'tanggal_selesai' => Carbon::now()->subDays(30)->addHours(6),
                'status' => 'selesai',
                'kuota_relawan' => 20,
                'image_url' => '/images/volunteer_examples/edukasi_gempa.jpg',
            ]
        );
        if ($event3) {
            $role3_1 = $event3->roles()->updateOrCreate(
                ['name' => 'Fasilitator'],
                ['description' => 'Memandu sesi workshop.', 'slots_needed' => 4, 'estimated_work_hours' => 6]
            );
             if ($relawanRafif) {
                $event3->relawan()->syncWithoutDetaching([
                    $relawanRafif->id => [
                        'status_partisipasi' => 'disetujui',
                        'status_kehadiran' => 'hadir', // Event finished, Rafif attended
                        'volunteer_event_role_id' => $role3_1->id,
                        'created_at' => Carbon::now()->subDays(35), 'updated_at' => Carbon::now()->subDays(30)
                    ]
                ]);
            }
        }
        
        // --- Event 4: Distribusi Logistik (Status Dibatalkan) ---
        $event4 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Distribusi Bantuan Logistik Cianjur'],
            [
                'deskripsi' => 'Membantu distribusi logistik untuk korban gempa Cianjur.',
                'lokasi' => 'Posko Utama Cianjur',
                'tanggal_mulai' => Carbon::now()->addDays(2),
                'tanggal_selesai' => Carbon::now()->addDays(3),
                'status' => 'dibatalkan',
                'kuota_relawan' => 25,
                'image_url' => '/images/volunteer_examples/distribusi_logistik.jpg',
            ]
        );
         if ($event4) {
            $role4_1 = $event4->roles()->updateOrCreate(
                ['name' => 'Pengemudi'],
                ['description' => 'Mengantarkan logistik ke titik distribusi.', 'slots_needed' => 5, 'estimated_work_hours' => 8]
            );
             if ($relawanBudi) { // Budi was supposed to join
                $event4->relawan()->syncWithoutDetaching([
                    $relawanBudi->id => [
                        'status_partisipasi' => 'disetujui', // Was approved before cancellation
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $role4_1->id,
                        'created_at' => Carbon::now()->subDays(1), 'updated_at' => Carbon::now()->subDays(1)
                    ]
                ]);
            }
        }

    }
}