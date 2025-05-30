<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Donation;
use App\Models\Distribution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DonationDistributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_distribution_details()
    {
        // Create test user
        $user = User::factory()->create();
        
        // Create a donation
        $donation = Donation::factory()->create([
            'user_id' => $user->id,
            'status' => 'distributed',
            'amount' => 1000000
        ]);

        // Create distribution details
        $distribution = Distribution::create([
            'donation_id' => $donation->id,
            'amount' => 1000000,
            'disaster' => 'Test Disaster',
            'description' => 'Test distribution description',
            'distributed_at' => now(),
            'proof_image' => 'test-proof.jpg'
        ]);

        // Test viewing as the donor
        $response = $this->actingAs($user)
            ->get(route('donations.show', $donation));

        $response->assertStatus(200)
            ->assertSee('Detail Distribusi Donasi')
            ->assertSee('Test Disaster')
            ->assertSee('Rp 1.000.000')
            ->assertSee('Test distribution description');
    }

    public function test_admin_can_add_distribution_details()
    {
        // Create admin user
        $admin = User::factory()->create(['is_admin' => true]);
        
        // Create a confirmed donation
        $donation = Donation::factory()->create([
            'status' => 'confirmed',
            'amount' => 2000000
        ]);

        Storage::fake('public');

        // Test adding distribution details
        $response = $this->actingAs($admin)
            ->post(route('admin.donations.distribute', $donation), [
                'amount' => 2000000,
                'disaster' => 'Test Disaster 2',
                'description' => 'Test distribution description 2',
                'distributed_at' => now()->format('Y-m-d'),
                'proof_image' => UploadedFile::fake()->image('distribution-proof.jpg')
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        // Verify distribution was created
        $this->assertDatabaseHas('distributions', [
            'donation_id' => $donation->id,
            'amount' => 2000000,
            'disaster' => 'Test Disaster 2'
        ]);

        // Verify donation status was updated
        $this->assertDatabaseHas('donations', [
            'id' => $donation->id,
            'status' => 'distributed'
        ]);
    }

    public function test_distribution_details_are_required()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $donation = Donation::factory()->create(['status' => 'confirmed']);

        $response = $this->actingAs($admin)
            ->post(route('admin.donations.distribute', $donation), []);

        $response->assertSessionHasErrors(['amount', 'disaster', 'distributed_at']);
    }

    public function test_distribution_amount_cannot_exceed_donation_amount()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $donation = Donation::factory()->create([
            'status' => 'confirmed',
            'amount' => 1000000
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.donations.distribute', $donation), [
                'amount' => 2000000, // More than donation amount
                'disaster' => 'Test Disaster',
                'distributed_at' => now()->format('Y-m-d')
            ]);

        $response->assertSessionHasErrors('amount');
    }
} 