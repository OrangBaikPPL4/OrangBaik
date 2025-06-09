<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCCreate2TestiTest extends DuskTestCase
{
    /**
     * @test
     * @group create2testi
     */
    public function TCCreate2TestiTest(): void
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
                    ->type('isicerita', 'Relawan sangat membantu')
                    ->press('KIRIM TESTIMONI')
                    ->visit('/testimoni');
        });
    }
}
