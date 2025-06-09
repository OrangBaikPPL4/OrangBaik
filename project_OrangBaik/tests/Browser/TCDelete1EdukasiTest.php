<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCDelete1EdukasiTest extends DuskTestCase
{
    /**
     * @test
     * @group del1edu
     */
    public function TCDelete1EdukasiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admina@gmail.com')
                    ->type('password', 'adminadmin')
                    ->press('LOG IN')
                    ->visit('/edukasi')
                    ->assertsee('Daftar Konten Edukasi')
                    ->press('Hapus')
                    ->visit('/edukasi');
        });
    }
}
