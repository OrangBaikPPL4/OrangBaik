<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCCreate3EdukasiTest extends DuskTestCase
{
    /**
     * @test
     * @group create3edu
     */
    public function TCCreate3EdukasiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admina@gmail.com')
                    ->type('password', 'adminadmin')
                    ->press('LOG IN')
                    ->visit('/edukasi/create')
                    ->assertSee('Buat Konten Edukasi')
                    ->type('title', 'Evakuasi Bencana')
                    ->type('content', 'Evakuasi saat adanya bencana')
                    ->select('category', 'Evakuasi')
                    ->attach('image', storage_path('app/public/images/siagabencana.jpg'))
                    ->press('Simpan Konten')
                    ->visit('/admin/edukasi');
        });
    }
}
