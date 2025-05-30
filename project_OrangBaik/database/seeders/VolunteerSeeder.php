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
     * Helper method to get weighted random status
     */
    private function getWeightedRandomStatus(array $weightedValues)
    {
        $rand = rand(1, 100);
        $total = 0;
        
        foreach ($weightedValues as $value => $weight) {
            $total += $weight;
            if ($rand <= $total) {
                return $value;
            }
        }
        
        // Default return first key if something goes wrong
        return array_key_first($weightedValues);
    }
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        // Get approved relawan for assigning to volunteer events
        $approvedRelawan = Relawan::where('verification_status', 'approved')->get();
        
        // Calculate how many relawan we can assign per event
        $approvedCount = $approvedRelawan->count();
        echo "Found {$approvedCount} approved relawan for assignment\n";

        // Fetch Relawan
        $relawanRafif = Relawan::whereHas('user', fn ($query) => $query->where('email', 'rafif.kusuma@example.com'))->first();
        $relawanBudi = Relawan::whereHas('user', fn ($query) => $query->where('email', 'budi.santoso@example.com'))->first();
        $relawanCitra = Relawan::whereHas('user', fn ($query) => $query->where('email', 'citra.lestari@example.com'))->first();

        // --- Event 1: Bersih Pantai ---
        $event1 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Aksi Bersih Pantai Cilacap'],
            [
                'deskripsi' => 'Bergabunglah dengan kami dalam membersihkan Pantai Cilacap dari sampah plastik dan lainnya untuk menjaga keindahan dan kelestarian lingkungan laut. Kegiatan ini bertujuan untuk mengurangi polusi plastik di laut, melindungi ekosistem laut, dan meningkatkan kesadaran masyarakat tentang pentingnya menjaga kebersihan pantai. Peserta akan dibagi dalam beberapa kelompok untuk membersihkan area pantai sepanjang 3 km. Peralatan pembersihan seperti sarung tangan, kantong sampah, dan alat pengumpul akan disediakan. Setelah kegiatan pembersihan, akan ada sesi edukasi tentang dampak sampah plastik terhadap ekosistem laut.',
                'lokasi' => 'Pantai Teluk Penyu, Cilacap, Jawa Tengah',
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
                    'description' => 'Mengkoordinasikan relawan di area spesifik, memastikan pembagian tugas merata, dan melaporkan perkembangan ke koordinator utama.',
                    'slots_needed' => 5,
                    'estimated_work_hours' => 5
                ]
            );
            $role1_2 = $event1->roles()->updateOrCreate(
                ['name' => 'Pengumpul Sampah'],
                [
                    'description' => 'Mengumpulkan sampah dari area pantai dan memisahkan sampah berdasarkan jenisnya (plastik, kaca, organik, dll).',
                    'slots_needed' => 30,
                    'estimated_work_hours' => 4
                ]
            );
            $role1_3 = $event1->roles()->updateOrCreate(
                ['name' => 'Dokumentasi'],
                [
                    'description' => 'Mendokumentasikan kegiatan melalui foto dan video untuk keperluan publikasi dan laporan kegiatan.',
                    'slots_needed' => 3,
                    'estimated_work_hours' => 5
                ]
            );
            $role1_4 = $event1->roles()->updateOrCreate(
                ['name' => 'Tim Edukasi'],
                [
                    'description' => 'Memberikan edukasi kepada peserta dan pengunjung pantai tentang pentingnya menjaga kebersihan pantai dan dampak sampah plastik.',
                    'slots_needed' => 7,
                    'estimated_work_hours' => 5
                ]
            );
            $role1_5 = $event1->roles()->updateOrCreate(
                ['name' => 'Tim Logistik'],
                [
                    'description' => 'Mengelola distribusi peralatan pembersihan dan konsumsi untuk para relawan.',
                    'slots_needed' => 5,
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
            
            // Assign random approved relawan to Event 1
            $availableRelawan = $approvedRelawan->where('id', '!=', $relawanRafif->id ?? 0)
                                               ->where('id', '!=', $relawanBudi->id ?? 0);
            
            // Take a smaller number to avoid errors
            $randomCount = min(5, $availableRelawan->count());
            $availableRelawan = $availableRelawan->random($randomCount);
                                               
            foreach ($availableRelawan as $relawan) {
                $randomRole = rand(1, 5);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role1_1->id; break;
                    case 2: $roleId = $role1_2->id; break;
                    case 3: $roleId = $role1_3->id; break;
                    case 4: $roleId = $role1_4->id; break;
                    case 5: $roleId = $role1_5->id; break;
                }
                
                $statusPartisipasi = ['disetujui', 'menunggu', 'ditolak'];
                $weightedStatus = ['disetujui' => 70, 'menunggu' => 25, 'ditolak' => 5];
                $status = $this->getWeightedRandomStatus($weightedStatus);
                
                $event1->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $status,
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => now(), 'updated_at' => now()
                    ]
                ]);
            }
        }

        // --- Event 2: Penggalangan Dana Bencana ---
        $event2 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Galang Dana untuk Korban Banjir Garut'],
            [
                'deskripsi' => 'Mari bantu saudara kita yang terdampak banjir di Garut dengan menggalang dana untuk kebutuhan mendesak mereka. Kegiatan ini bertujuan untuk mengumpulkan dana bantuan yang akan disalurkan untuk kebutuhan pangan, pakaian, obat-obatan, dan kebutuhan dasar lainnya bagi korban banjir di Garut. Penggalangan dana akan dilakukan secara online melalui platform crowdfunding dan secara offline di beberapa posko yang tersebar di Bandung. Semua dana yang terkumpul akan dilaporkan secara transparan dan disalurkan langsung ke lokasi bencana melalui tim relawan yang berada di lapangan.',
                'lokasi' => 'Online & Posko Bantuan Bandung (Jl. Asia Afrika, Jl. Dago, Jl. Buah Batu)',
                'tanggal_mulai' => Carbon::now()->addDays(5),
                'tanggal_selesai' => Carbon::now()->addDays(25),
                'status' => 'aktif',
                'kuota_relawan' => 25,
                'image_url' => '/images/volunteer_examples/galang_dana.jpg',
            ]
        );

        if ($event2) {
            $role2_1 = $event2->roles()->updateOrCreate(
                ['name' => 'Koordinator Penggalangan Dana'],
                ['description' => 'Mengkoordinasikan seluruh kegiatan penggalangan dana, membuat laporan perkembangan, dan memastikan transparansi penyaluran dana.', 'slots_needed' => 3, 'estimated_work_hours' => 20]
            );
            $role2_2 = $event2->roles()->updateOrCreate(
                ['name' => 'Tim Media Sosial'],
                ['description' => 'Mempromosikan kegiatan melalui media sosial, membuat konten kampanye, dan merespon pertanyaan dari donatur potensial.', 'slots_needed' => 7, 'estimated_work_hours' => 15]
            );
            $role2_3 = $event2->roles()->updateOrCreate(
                ['name' => 'Petugas Posko'],
                ['description' => 'Menjaga posko penggalangan dana offline, mencatat donasi yang masuk, dan memberikan informasi kepada masyarakat.', 'slots_needed' => 10, 'estimated_work_hours' => 25]
            );
            $role2_4 = $event2->roles()->updateOrCreate(
                ['name' => 'Tim Penyaluran Bantuan'],
                ['description' => 'Bertanggung jawab untuk menyalurkan bantuan langsung ke lokasi bencana dan memastikan bantuan sampai ke tangan yang membutuhkan.', 'slots_needed' => 5, 'estimated_work_hours' => 30]
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
            
            // Assign random approved relawan to Event 2
            $availableRelawan = $approvedRelawan->where('id', '!=', $relawanCitra->id ?? 0)
                                               ->where('id', '!=', $relawanBudi->id ?? 0);
            
            // Take a smaller number to avoid errors
            $randomCount = min(5, $availableRelawan->count());
            $availableRelawan = $availableRelawan->random($randomCount);
                                               
            foreach ($availableRelawan as $relawan) {
                $randomRole = rand(1, 4);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role2_1->id; break;
                    case 2: $roleId = $role2_2->id; break;
                    case 3: $roleId = $role2_3->id; break;
                    case 4: $roleId = $role2_4->id; break;
                }
                
                $weightedStatus = ['disetujui' => 70, 'menunggu' => 25, 'ditolak' => 5];
                $status = $this->getWeightedRandomStatus($weightedStatus);
                
                $event2->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $status,
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => now(), 'updated_at' => now()
                    ]
                ]);
            }
        }
        
        // --- Event 3: Edukasi Mitigasi Bencana (Status Selesai) ---
        $event3 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Workshop Kesiapsiagaan Bencana Gempa'],
            [
                'deskripsi' => 'Workshop untuk meningkatkan pemahaman masyarakat tentang mitigasi dan kesiapsiagaan menghadapi bencana gempa bumi. Kegiatan ini akan mencakup simulasi gempa, teknik evakuasi, pertolongan pertama, dan penyusunan rencana kesiapsiagaan keluarga. Peserta akan mendapatkan pengetahuan praktis tentang cara menyelamatkan diri dan membantu orang lain saat terjadi gempa. Workshop akan dibawakan oleh para ahli mitigasi bencana dan relawan berpengalaman.',
                'lokasi' => 'Aula Kecamatan Sukajadi, Bandung, Jawa Barat',
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
                ['description' => 'Memandu sesi workshop dan memastikan materi tersampaikan dengan baik kepada peserta.', 'slots_needed' => 5, 'estimated_work_hours' => 6]
            );
            $role3_2 = $event3->roles()->updateOrCreate(
                ['name' => 'Tim Simulasi'],
                ['description' => 'Menyiapkan dan menjalankan simulasi gempa bumi untuk memberikan pengalaman praktis kepada peserta.', 'slots_needed' => 8, 'estimated_work_hours' => 6]
            );
            $role3_3 = $event3->roles()->updateOrCreate(
                ['name' => 'Tim Dokumentasi'],
                ['description' => 'Mendokumentasikan seluruh kegiatan workshop untuk keperluan laporan dan publikasi.', 'slots_needed' => 3, 'estimated_work_hours' => 6]
            );
            $role3_4 = $event3->roles()->updateOrCreate(
                ['name' => 'Tim Logistik'],
                ['description' => 'Menyiapkan perlengkapan workshop, konsumsi, dan materi untuk peserta.', 'slots_needed' => 4, 'estimated_work_hours' => 7]
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
            
            // Assign random approved relawan to Event 3 (completed event)
            $availableRelawan = $approvedRelawan->where('id', '!=', $relawanRafif->id ?? 0);
            
            // Take a smaller number to avoid errors
            $randomCount = min(5, $availableRelawan->count());
            $availableRelawan = $availableRelawan->random($randomCount);
                                               
            foreach ($availableRelawan as $relawan) {
                $randomRole = rand(1, 4);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role3_1->id; break;
                    case 2: $roleId = $role3_2->id; break;
                    case 3: $roleId = $role3_3->id; break;
                    case 4: $roleId = $role3_4->id; break;
                }
                
                // For completed event, most participants were approved and attended
                $statusPartisipasi = 'disetujui';
                $statusKehadiran = rand(1, 10) <= 8 ? 'hadir' : 'tidak hadir'; // 80% attended
                
                $event3->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $statusPartisipasi,
                        'status_kehadiran' => $statusKehadiran,
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => Carbon::now()->subDays(35), 
                        'updated_at' => Carbon::now()->subDays(30)
                    ]
                ]);
            }
        }
        
        // --- Event 4: Distribusi Logistik (Status Dibatalkan) ---
        $event4 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Distribusi Bantuan Logistik Cianjur'],
            [
                'deskripsi' => 'Membantu distribusi logistik untuk korban gempa Cianjur. Kegiatan ini bertujuan untuk menyalurkan bantuan berupa makanan, pakaian, obat-obatan, dan kebutuhan dasar lainnya kepada korban gempa di daerah terpencil yang sulit dijangkau. Relawan akan membantu dalam proses sortir bantuan, pengepakan, dan distribusi langsung ke lokasi-lokasi pengungsian. Dibutuhkan relawan yang memiliki ketahanan fisik baik karena medan yang akan ditempuh cukup berat.',
                'lokasi' => 'Posko Utama Cianjur, Jawa Barat',
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
                ['description' => 'Mengantarkan logistik ke titik distribusi dengan menggunakan kendaraan yang disediakan.', 'slots_needed' => 5, 'estimated_work_hours' => 8]
            );
            $role4_2 = $event4->roles()->updateOrCreate(
                ['name' => 'Tim Sortir'],
                ['description' => 'Menyortir bantuan berdasarkan jenis dan kebutuhan untuk memudahkan proses distribusi.', 'slots_needed' => 8, 'estimated_work_hours' => 6]
            );
            $role4_3 = $event4->roles()->updateOrCreate(
                ['name' => 'Tim Pengepakan'],
                ['description' => 'Mengepak bantuan ke dalam paket-paket yang siap didistribusikan ke pengungsian.', 'slots_needed' => 7, 'estimated_work_hours' => 6]
            );
            $role4_4 = $event4->roles()->updateOrCreate(
                ['name' => 'Koordinator Lapangan'],
                ['description' => 'Mengkoordinasikan proses distribusi di lapangan dan memastikan bantuan sampai ke penerima yang tepat.', 'slots_needed' => 5, 'estimated_work_hours' => 8]
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
            
            // Assign random approved relawan to Event 4 (cancelled event)
            $availableRelawan = $approvedRelawan->where('id', '!=', $relawanBudi->id ?? 0);
            
            // Take a smaller number to avoid errors
            $randomCount = min(5, $availableRelawan->count());
            $availableRelawan = $availableRelawan->random($randomCount);
                                               
            foreach ($availableRelawan as $relawan) {
                $randomRole = rand(1, 4);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role4_1->id; break;
                    case 2: $roleId = $role4_2->id; break;
                    case 3: $roleId = $role4_3->id; break;
                    case 4: $roleId = $role4_4->id; break;
                }
                
                // For cancelled event, all participants were either approved or waiting
                $statusPartisipasi = rand(1, 10) <= 7 ? 'disetujui' : 'menunggu'; // 70% were approved
                
                $event4->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $statusPartisipasi,
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => Carbon::now()->subDays(3), 
                        'updated_at' => Carbon::now()->subDays(1)
                    ]
                ]);
            }
        }
        
        // --- Event 5: Penanaman Pohon Mangrove ---
        $event5 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Penanaman 1000 Pohon Mangrove'],
            [
                'deskripsi' => 'Kegiatan penanaman 1000 pohon mangrove di pesisir pantai Muara Gembong untuk mencegah abrasi dan menjaga ekosistem pesisir. Mangrove memiliki peran penting dalam melindungi garis pantai dari erosi, menyerap karbon, dan menjadi habitat bagi berbagai spesies laut. Kegiatan ini akan dimulai dengan pengarahan tentang teknik penanaman yang benar, dilanjutkan dengan penanaman bersama, dan diakhiri dengan diskusi tentang pentingnya pelestarian ekosistem mangrove.',
                'lokasi' => 'Pesisir Muara Gembong, Bekasi, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(15),
                'tanggal_selesai' => Carbon::now()->addDays(15)->addHours(8),
                'status' => 'aktif',
                'kuota_relawan' => 40,
                'image_url' => '/images/volunteer_examples/tanam_mangrove.jpg',
            ]
        );
        
        if ($event5) {
            $role5_1 = $event5->roles()->updateOrCreate(
                ['name' => 'Koordinator Area'],
                ['description' => 'Mengkoordinasikan relawan di area penanaman tertentu dan memastikan teknik penanaman yang benar.', 'slots_needed' => 5, 'estimated_work_hours' => 8]
            );
            $role5_2 = $event5->roles()->updateOrCreate(
                ['name' => 'Tim Edukasi'],
                ['description' => 'Memberikan pengarahan tentang teknik penanaman dan pentingnya ekosistem mangrove.', 'slots_needed' => 5, 'estimated_work_hours' => 8]
            );
            $role5_3 = $event5->roles()->updateOrCreate(
                ['name' => 'Tim Logistik'],
                ['description' => 'Menyiapkan bibit mangrove, peralatan tanam, dan konsumsi untuk relawan.', 'slots_needed' => 10, 'estimated_work_hours' => 8]
            );
            $role5_4 = $event5->roles()->updateOrCreate(
                ['name' => 'Tim Dokumentasi'],
                ['description' => 'Mendokumentasikan kegiatan untuk keperluan publikasi dan laporan.', 'slots_needed' => 3, 'estimated_work_hours' => 8]
            );
            $role5_5 = $event5->roles()->updateOrCreate(
                ['name' => 'Relawan Penanaman'],
                ['description' => 'Melakukan penanaman bibit mangrove di lokasi yang telah ditentukan.', 'slots_needed' => 17, 'estimated_work_hours' => 6]
            );
            
            // Assign random approved relawan to Event 5
            // Take a smaller number to avoid errors
            $randomCount = min(5, $approvedRelawan->count());
            $assignedRelawan = $approvedRelawan->random($randomCount);
                                               
            foreach ($assignedRelawan as $relawan) {
                $randomRole = rand(1, 5);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role5_1->id; break;
                    case 2: $roleId = $role5_2->id; break;
                    case 3: $roleId = $role5_3->id; break;
                    case 4: $roleId = $role5_4->id; break;
                    case 5: $roleId = $role5_5->id; break;
                }
                
                $weightedStatus = ['disetujui' => 60, 'menunggu' => 35, 'ditolak' => 5];
                $status = $this->getWeightedRandomStatus($weightedStatus);
                
                $event5->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $status,
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => Carbon::now()->subDays(5), 
                        'updated_at' => Carbon::now()->subDays(3)
                    ]
                ]);
            }
        }
        
        // --- Event 6: Edukasi Sanitasi dan Kesehatan ---
        $event6 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Edukasi Sanitasi dan Kesehatan di Daerah Banjir'],
            [
                'deskripsi' => 'Program edukasi tentang sanitasi dan kesehatan bagi masyarakat di daerah rawan banjir. Kegiatan ini bertujuan untuk meningkatkan kesadaran masyarakat tentang pentingnya sanitasi yang baik untuk mencegah penyakit pasca banjir seperti diare, demam berdarah, dan penyakit kulit. Relawan akan memberikan penyuluhan tentang cara menjaga kebersihan air, pengolahan sampah, dan praktik hidup bersih dan sehat. Selain itu, relawan juga akan membagikan kit sanitasi dasar kepada masyarakat.',
                'lokasi' => 'Kampung Melayu, Jakarta Timur, DKI Jakarta',
                'tanggal_mulai' => Carbon::now()->addDays(7),
                'tanggal_selesai' => Carbon::now()->addDays(7)->addHours(6),
                'status' => 'aktif',
                'kuota_relawan' => 25,
                'image_url' => '/images/volunteer_examples/edukasi_sanitasi.jpg',
            ]
        );
        
        if ($event6) {
            $role6_1 = $event6->roles()->updateOrCreate(
                ['name' => 'Fasilitator Edukasi'],
                ['description' => 'Memberikan penyuluhan tentang sanitasi dan kesehatan kepada masyarakat.', 'slots_needed' => 8, 'estimated_work_hours' => 6]
            );
            $role6_2 = $event6->roles()->updateOrCreate(
                ['name' => 'Tim Distribusi Kit Sanitasi'],
                ['description' => 'Membagikan kit sanitasi dasar kepada masyarakat dan menjelaskan cara penggunaannya.', 'slots_needed' => 10, 'estimated_work_hours' => 6]
            );
            $role6_3 = $event6->roles()->updateOrCreate(
                ['name' => 'Tim Dokumentasi'],
                ['description' => 'Mendokumentasikan kegiatan untuk keperluan publikasi dan laporan.', 'slots_needed' => 3, 'estimated_work_hours' => 6]
            );
            $role6_4 = $event6->roles()->updateOrCreate(
                ['name' => 'Koordinator Lapangan'],
                ['description' => 'Mengkoordinasikan jalannya kegiatan dan menjadi penghubung dengan tokoh masyarakat setempat.', 'slots_needed' => 4, 'estimated_work_hours' => 7]
            );
            
            // Assign random approved relawan to Event 6
            // Take a smaller number to avoid errors
            $randomCount = min(5, $approvedRelawan->count());
            $assignedRelawan = $approvedRelawan->random($randomCount);
                                               
            foreach ($assignedRelawan as $relawan) {
                $randomRole = rand(1, 4);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role6_1->id; break;
                    case 2: $roleId = $role6_2->id; break;
                    case 3: $roleId = $role6_3->id; break;
                    case 4: $roleId = $role6_4->id; break;
                }
                
                $weightedStatus = ['disetujui' => 65, 'menunggu' => 30, 'ditolak' => 5];
                $status = $this->getWeightedRandomStatus($weightedStatus);
                
                $event6->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $status,
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => Carbon::now()->subDays(4), 
                        'updated_at' => Carbon::now()->subDays(2)
                    ]
                ]);
            }
        }
        
        // --- Event 7: Pembangunan Rumah Sementara ---
        $event7 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Pembangunan Rumah Sementara Korban Gempa'],
            [
                'deskripsi' => 'Program pembangunan rumah sementara bagi korban gempa yang rumahnya rusak berat. Kegiatan ini bertujuan untuk menyediakan tempat tinggal yang layak bagi korban gempa selama proses rehabilitasi dan rekonstruksi rumah permanen mereka. Relawan akan membantu dalam proses pembangunan rumah sementara dengan menggunakan material yang telah disediakan. Dibutuhkan relawan yang memiliki keterampilan dasar dalam pertukangan, namun relawan tanpa keterampilan khusus juga dapat membantu dalam proses pengangkutan material dan logistik.',
                'lokasi' => 'Desa Sukamulya, Cianjur, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(12),
                'tanggal_selesai' => Carbon::now()->addDays(17),
                'status' => 'aktif',
                'kuota_relawan' => 35,
                'image_url' => '/images/volunteer_examples/huntara.jpg',
            ]
        );
        
        if ($event7) {
            $role7_1 = $event7->roles()->updateOrCreate(
                ['name' => 'Tukang'],
                ['description' => 'Melakukan pekerjaan konstruksi yang membutuhkan keterampilan pertukangan.', 'slots_needed' => 10, 'estimated_work_hours' => 40]
            );
            $role7_2 = $event7->roles()->updateOrCreate(
                ['name' => 'Asisten Tukang'],
                ['description' => 'Membantu tukang dalam proses pembangunan dan menyiapkan material yang dibutuhkan.', 'slots_needed' => 15, 'estimated_work_hours' => 40]
            );
            $role7_3 = $event7->roles()->updateOrCreate(
                ['name' => 'Tim Logistik'],
                ['description' => 'Mengelola persediaan material dan konsumsi untuk para relawan.', 'slots_needed' => 5, 'estimated_work_hours' => 40]
            );
            $role7_4 = $event7->roles()->updateOrCreate(
                ['name' => 'Koordinator Lapangan'],
                ['description' => 'Mengkoordinasikan proses pembangunan dan menjadi penghubung dengan pihak desa dan penerima bantuan.', 'slots_needed' => 5, 'estimated_work_hours' => 40]
            );
            
            // Assign random approved relawan to Event 7
            // Take a smaller number to avoid errors
            $randomCount = min(5, $approvedRelawan->count());
            $assignedRelawan = $approvedRelawan->random($randomCount);
                                               
            foreach ($assignedRelawan as $relawan) {
                $randomRole = rand(1, 4);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role7_1->id; break;
                    case 2: $roleId = $role7_2->id; break;
                    case 3: $roleId = $role7_3->id; break;
                    case 4: $roleId = $role7_4->id; break;
                }
                
                $weightedStatus = ['disetujui' => 60, 'menunggu' => 35, 'ditolak' => 5];
                $status = $this->getWeightedRandomStatus($weightedStatus);
                
                $event7->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $status,
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => Carbon::now()->subDays(3), 
                        'updated_at' => Carbon::now()->subDays(1)
                    ]
                ]);
            }
        }
        
        // --- Event 8: Trauma Healing Anak-anak ---
        $event8 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Trauma Healing untuk Anak Korban Bencana'],
            [
                'deskripsi' => 'Program trauma healing untuk anak-anak korban bencana alam. Kegiatan ini bertujuan untuk membantu anak-anak mengatasi trauma pasca bencana melalui berbagai aktivitas kreatif seperti menggambar, bermain, bercerita, dan bernyanyi. Relawan akan memfasilitasi kegiatan-kegiatan tersebut dan menciptakan suasana yang menyenangkan bagi anak-anak. Dibutuhkan relawan yang memiliki kemampuan berkomunikasi yang baik dengan anak-anak dan memiliki kesabaran tinggi.',
                'lokasi' => 'Pengungsian Stadion Maguwoharjo, Sleman, DI Yogyakarta',
                'tanggal_mulai' => Carbon::now()->addDays(8),
                'tanggal_selesai' => Carbon::now()->addDays(9),
                'status' => 'aktif',
                'kuota_relawan' => 20,
                'image_url' => '/images/volunteer_examples/trauma_healing.jpg',
            ]
        );
        
        if ($event8) {
            $role8_1 = $event8->roles()->updateOrCreate(
                ['name' => 'Fasilitator Permainan'],
                ['description' => 'Memfasilitasi permainan edukatif dan rekreatif untuk anak-anak.', 'slots_needed' => 8, 'estimated_work_hours' => 16]
            );
            $role8_2 = $event8->roles()->updateOrCreate(
                ['name' => 'Fasilitator Seni'],
                ['description' => 'Memfasilitasi kegiatan seni seperti menggambar, mewarnai, dan kerajinan tangan.', 'slots_needed' => 6, 'estimated_work_hours' => 16]
            );
            $role8_3 = $event8->roles()->updateOrCreate(
                ['name' => 'Tim Dokumentasi'],
                ['description' => 'Mendokumentasikan kegiatan untuk keperluan publikasi dan laporan.', 'slots_needed' => 3, 'estimated_work_hours' => 16]
            );
            $role8_4 = $event8->roles()->updateOrCreate(
                ['name' => 'Tim Logistik'],
                ['description' => 'Menyiapkan perlengkapan kegiatan dan konsumsi untuk anak-anak dan relawan.', 'slots_needed' => 3, 'estimated_work_hours' => 16]
            );
            
            // Assign random approved relawan to Event 8
            // Take a smaller number to avoid errors
            $randomCount = min(5, $approvedRelawan->count());
            $assignedRelawan = $approvedRelawan->random($randomCount);
                                               
            foreach ($assignedRelawan as $relawan) {
                $randomRole = rand(1, 4);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role8_1->id; break;
                    case 2: $roleId = $role8_2->id; break;
                    case 3: $roleId = $role8_3->id; break;
                    case 4: $roleId = $role8_4->id; break;
                }
                
                $weightedStatus = ['disetujui' => 70, 'menunggu' => 25, 'ditolak' => 5];
                $status = $this->getWeightedRandomStatus($weightedStatus);
                
                $event8->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $status,
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => Carbon::now()->subDays(5), 
                        'updated_at' => Carbon::now()->subDays(2)
                    ]
                ]);
            }
        }
        
        // --- Event 9: Dapur Umum (Status Selesai) ---
        $event9 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Dapur Umum untuk Korban Banjir Jakarta'],
            [
                'deskripsi' => 'Program dapur umum untuk menyediakan makanan bagi korban banjir di Jakarta. Kegiatan ini bertujuan untuk memastikan korban banjir mendapatkan makanan yang layak selama berada di pengungsian. Relawan akan membantu dalam proses persiapan bahan makanan, memasak, pengemasan, dan distribusi makanan ke titik-titik pengungsian. Dibutuhkan relawan yang memiliki keterampilan dasar dalam memasak dan memiliki ketahanan fisik yang baik.',
                'lokasi' => 'Posko Bantuan Kemayoran, Jakarta Pusat, DKI Jakarta',
                'tanggal_mulai' => Carbon::now()->subDays(10),
                'tanggal_selesai' => Carbon::now()->subDays(5),
                'status' => 'selesai',
                'kuota_relawan' => 30,
                'image_url' => '/images/volunteer_examples/dapur_umum.jpg',
            ]
        );
        
        if ($event9) {
            $role9_1 = $event9->roles()->updateOrCreate(
                ['name' => 'Tim Persiapan Bahan'],
                ['description' => 'Menyiapkan dan mengolah bahan makanan sebelum dimasak.', 'slots_needed' => 10, 'estimated_work_hours' => 30]
            );
            $role9_2 = $event9->roles()->updateOrCreate(
                ['name' => 'Tim Masak'],
                ['description' => 'Memasak makanan untuk korban banjir.', 'slots_needed' => 8, 'estimated_work_hours' => 30]
            );
            $role9_3 = $event9->roles()->updateOrCreate(
                ['name' => 'Tim Pengemasan'],
                ['description' => 'Mengemas makanan yang sudah siap untuk didistribusikan.', 'slots_needed' => 7, 'estimated_work_hours' => 30]
            );
            $role9_4 = $event9->roles()->updateOrCreate(
                ['name' => 'Tim Distribusi'],
                ['description' => 'Mendistribusikan makanan ke titik-titik pengungsian.', 'slots_needed' => 5, 'estimated_work_hours' => 30]
            );
            
            // Assign random approved relawan to Event 9 (completed event)
            // Take a smaller number to avoid errors
            $randomCount = min(5, $approvedRelawan->count());
            $assignedRelawan = $approvedRelawan->random($randomCount);
                                               
            foreach ($assignedRelawan as $relawan) {
                $randomRole = rand(1, 4);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role9_1->id; break;
                    case 2: $roleId = $role9_2->id; break;
                    case 3: $roleId = $role9_3->id; break;
                    case 4: $roleId = $role9_4->id; break;
                }
                
                // For completed event, most participants were approved and attended
                $statusPartisipasi = 'disetujui';
                $statusKehadiran = rand(1, 10) <= 8 ? 'hadir' : 'tidak hadir'; // 80% attended
                
                $event9->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $statusPartisipasi,
                        'status_kehadiran' => $statusKehadiran,
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => Carbon::now()->subDays(15), 
                        'updated_at' => Carbon::now()->subDays(5)
                    ]
                ]);
            }
        }
        
        // --- Event 10: Penghijauan Daerah Aliran Sungai ---
        $event10 = Volunteer::updateOrCreate(
            ['nama_acara' => 'Penghijauan Daerah Aliran Sungai Citarum'],
            [
                'deskripsi' => 'Program penghijauan di sepanjang Daerah Aliran Sungai (DAS) Citarum untuk mencegah erosi dan banjir. Kegiatan ini bertujuan untuk merehabilitasi DAS Citarum yang telah mengalami degradasi akibat penggundulan hutan dan alih fungsi lahan. Relawan akan membantu dalam proses penanaman pohon di sepanjang bantaran sungai dan lereng-lereng yang rawan longsor. Selain itu, relawan juga akan memberikan edukasi kepada masyarakat sekitar tentang pentingnya menjaga kelestarian DAS.',
                'lokasi' => 'Daerah Aliran Sungai Citarum, Bandung, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(20),
                'tanggal_selesai' => Carbon::now()->addDays(20)->addHours(8),
                'status' => 'aktif',
                'kuota_relawan' => 45,
                'image_url' => '/images/volunteer_examples/penghijauan_das.jpg',
            ]
        );
        
        if ($event10) {
            $role10_1 = $event10->roles()->updateOrCreate(
                ['name' => 'Koordinator Area'],
                ['description' => 'Mengkoordinasikan relawan di area penanaman tertentu dan memastikan teknik penanaman yang benar.', 'slots_needed' => 5, 'estimated_work_hours' => 8]
            );
            $role10_2 = $event10->roles()->updateOrCreate(
                ['name' => 'Tim Edukasi'],
                ['description' => 'Memberikan edukasi kepada masyarakat sekitar tentang pentingnya menjaga kelestarian DAS.', 'slots_needed' => 8, 'estimated_work_hours' => 8]
            );
            $role10_3 = $event10->roles()->updateOrCreate(
                ['name' => 'Tim Logistik'],
                ['description' => 'Menyiapkan bibit pohon, peralatan tanam, dan konsumsi untuk relawan.', 'slots_needed' => 10, 'estimated_work_hours' => 8]
            );
            $role10_4 = $event10->roles()->updateOrCreate(
                ['name' => 'Tim Dokumentasi'],
                ['description' => 'Mendokumentasikan kegiatan untuk keperluan publikasi dan laporan.', 'slots_needed' => 2, 'estimated_work_hours' => 8]
            );
            $role10_5 = $event10->roles()->updateOrCreate(
                ['name' => 'Relawan Penanaman'],
                ['description' => 'Melakukan penanaman bibit pohon di lokasi yang telah ditentukan.', 'slots_needed' => 20, 'estimated_work_hours' => 6]
            );
            
            // Assign random approved relawan to Event 10
            // Take a smaller number to avoid errors
            $randomCount = min(5, $approvedRelawan->count());
            $assignedRelawan = $approvedRelawan->random($randomCount);
                                               
            foreach ($assignedRelawan as $relawan) {
                $randomRole = rand(1, 5);
                $roleId = null;
                
                switch ($randomRole) {
                    case 1: $roleId = $role10_1->id; break;
                    case 2: $roleId = $role10_2->id; break;
                    case 3: $roleId = $role10_3->id; break;
                    case 4: $roleId = $role10_4->id; break;
                    case 5: $roleId = $role10_5->id; break;
                }
                
                $weightedStatus = ['disetujui' => 55, 'menunggu' => 40, 'ditolak' => 5];
                $status = $this->getWeightedRandomStatus($weightedStatus);
                
                $event10->relawan()->syncWithoutDetaching([
                    $relawan->id => [
                        'status_partisipasi' => $status,
                        'status_kehadiran' => 'belum hadir',
                        'volunteer_event_role_id' => $roleId,
                        'created_at' => Carbon::now()->subDays(2), 
                        'updated_at' => Carbon::now()->subDay()
                    ]
                ]);
            }
        }
    }
}