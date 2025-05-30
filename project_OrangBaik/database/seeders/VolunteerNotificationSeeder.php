<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VolunteerNotification;
use App\Models\User;
use App\Models\Relawan;
use App\Models\Volunteer;
use Carbon\Carbon;

class VolunteerNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users, relawan, and volunteer events
        $relawanData = Relawan::with('user')->get();
        $volunteerEvents = Volunteer::all();
        
        if ($relawanData->isEmpty() || $volunteerEvents->isEmpty()) {
            return; // Skip if no relawan or volunteer events exist
        }
        
        // Define notification types
        $notificationTypes = [
            'event_update',
            'event_cancelled',
            'event_postponed',
            'participation_approved',
            'participation_rejected',
            'event_reminder',
            'info',
        ];
        
        // Create notifications for each relawan
        foreach ($relawanData as $relawan) {
            if (!$relawan->user) continue;
            
            // Get 1-3 random volunteer events for this relawan
            $eventCount = min(rand(1, 3), $volunteerEvents->count());
            $selectedEvents = $volunteerEvents->random($eventCount);
            
            foreach ($selectedEvents as $event) {
                // Create 2-4 notifications per event
                $notificationCount = rand(2, 4);
                
                for ($i = 0; $i < $notificationCount; $i++) {
                    $type = $notificationTypes[array_rand($notificationTypes)];
                    $title = '';
                    $message = '';
                    $daysAgo = rand(1, 30);
                    $isRead = rand(0, 1) === 1;
                    
                    // Set title and message based on notification type
                    switch ($type) {
                        case 'event_update':
                            $title = "Perubahan Detail Acara: {$event->nama_acara}";
                            $message = "Detail acara '{$event->nama_acara}' telah diperbarui. Silakan cek halaman acara untuk informasi terbaru.";
                            break;
                        case 'event_cancelled':
                            $title = "Pembatalan Acara: {$event->nama_acara}";
                            $message = "Acara '{$event->nama_acara}' yang Anda ikuti telah dibatalkan. Mohon maaf atas ketidaknyamanannya.";
                            break;
                        case 'event_postponed':
                            $title = "Penundaan Acara: {$event->nama_acara}";
                            $message = "Acara '{$event->nama_acara}' yang Anda ikuti telah ditunda. Silakan cek detail acara untuk informasi lebih lanjut.";
                            break;
                        case 'participation_approved':
                            $title = "Partisipasi Disetujui: {$event->nama_acara}";
                            $message = "Selamat! Partisipasi Anda dalam acara '{$event->nama_acara}' telah disetujui. Silakan cek detail acara untuk informasi lebih lanjut.";
                            break;
                        case 'participation_rejected':
                            $title = "Partisipasi Ditolak: {$event->nama_acara}";
                            $message = "Mohon maaf, partisipasi Anda dalam acara '{$event->nama_acara}' belum dapat disetujui. Silakan cek acara volunteer lainnya yang tersedia.";
                            break;
                        case 'event_reminder':
                            $title = "Pengingat Acara: {$event->nama_acara}";
                            $message = "Acara '{$event->nama_acara}' akan berlangsung dalam 2 hari. Pastikan Anda telah mempersiapkan diri dan hadir tepat waktu.";
                            break;
                        case 'info':
                            $title = "Informasi Acara: {$event->nama_acara}";
                            $message = "Informasi tambahan untuk acara '{$event->nama_acara}' telah ditambahkan. Silakan cek halaman acara untuk detailnya.";
                            break;
                    }
                    
                    VolunteerNotification::create([
                        'relawan_id' => $relawan->id,
                        'volunteer_id' => $event->id,
                        'title' => $title,
                        'message' => $message,
                        'type' => $type,
                        'is_read' => $isRead,
                        'created_at' => Carbon::now()->subDays($daysAgo),
                        'updated_at' => Carbon::now()->subDays($daysAgo),
                    ]);
                }
            }
        }
    }
}
