<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCCreate3TestiTest extends DuskTestCase
{
    /**
     * @test
     * @group create3testi
     */
    public function TCCreate3TestiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'hafizhah@gmail.com')
                    ->type('password', 'hafizhah')
                    ->press('LOG IN')
                    ->visit('/testimoni')
                    ->clicklink('Tambah Testimoni')
                    ->assertsee('Buat Testimoni')
                    ->visit('/testimoni/create')
                    ->type('lokasi', 'Bandung')
                    ->select('jenis_bencana', 'Banjir')
                    ->type('isicerita', 'Relawan sangat membantu')
                    ->attach('foto', storage_path('app/public/foto_testimoni/banjir.jpg'))
                    ->press('KIRIM TESTIMONI')
                    ->visit('/testimoni');
        });
    }
}
