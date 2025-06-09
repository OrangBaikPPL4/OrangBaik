<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCCreate4EdukasiTest extends DuskTestCase
{
    /**
     * @test
     * @group create4edu
     */
    public function TCCreate4EdukasiTest(): void
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
                    ->attach('image', storage_path('app/public/videos/gempa.mp4'))
                    ->press('Simpan Konten')
                    ->visit('/admin/edukasi');
        });
    }
}
