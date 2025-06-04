<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PBI39_01Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testKirimPertanyaanTambahan()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('user_email', 'user@example.com')
                    ->type('feedback', 'Apakah bisa relawan dari luar kota?')
                    ->press('Kirim Pertanyaan')
                    ->assertSee('Terima kasih atas masukannya!');
        });
    }
}
