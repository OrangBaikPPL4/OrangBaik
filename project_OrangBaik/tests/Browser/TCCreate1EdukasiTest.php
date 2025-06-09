<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCCreate1EdukasiTest extends DuskTestCase
{
    /**
     * @test
     * @group create1edu
     */
    public function TCCreate1EdukasiTest(): void 
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
                    ->select('category', 'Evakuasi')
                    ->press('Simpan Konten')
                    ->visit('/admin/edukasi');
        });
    }
}