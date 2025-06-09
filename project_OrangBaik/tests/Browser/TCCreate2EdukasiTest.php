<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCCreate2EdukasiTest extends DuskTestCase
{
    /**
     * @test
     * @group create2edu
     */
    public function TCCreate2EdukasiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'adminh@gmail.com')
                    ->type('password', 'adminadmin')
                    ->press('LOG IN')
                    ->visit('/edukasi/create')
                    ->assertsee('Buat Konten Edukasi')
                    ->type('title', 'Evakuasi Bencana')
                    ->type('content', 'Evakuasi saat adanya bencana')
                    ->press('Simpan Konten')
                    ->visit('/edukasi/create');
        });
    }
}
