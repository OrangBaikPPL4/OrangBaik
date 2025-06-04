<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // Users and core data
            UserSeeder::class,
            RelawanSeeder::class,
            
            // Volunteer events
            VolunteerSeeder::class,
            VolunteerNotificationSeeder::class,
            
            // Disaster response
            MisiSeeder::class,
            DisasterReportSeeder::class,
            RequestBantuanSeeder::class,
            
            // Educational content
            EdukasiSeeder::class,
            
            // Donations
            DonationSeeder::class,
            
            // FAQ
            FaqSeeder::class,
            
            // Announcements
            AnnouncementSeeder::class,
            
            // Testimonials
            TestimoniSeeder::class,
        ]);

        $this->call([
            AdminSeeder::class,
        ]);
    }
}