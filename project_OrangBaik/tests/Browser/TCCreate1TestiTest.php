<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCCreate1TestiTest extends DuskTestCase
{
    /**
     * @test
     * @group create1testi
     */
    public function TCCreate1TestiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'hafizhah@gmail.com')
                    ->type('password', 'hafizhah')
                    ->press('LOG IN')
                    ->visit('/testimoni')
                    ->clickLink('Tambah Testimoni')
                    ->assertsee('Buat Testimoni')
                    ->visit('/testimoni/create')
                    ->type('lokasi', 'Bandung')
                    ->select('jenis_bencana', 'Banjir')
                    ->type('isicerita', 'Relawan sangat membantu')
                    ->press('KIRIM TESTIMONI')
                    ->visit('/testimoni');
        });
    }
}
