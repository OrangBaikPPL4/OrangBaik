<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCView1EdukasiTest extends DuskTestCase
{
    /**
     * @test
     * @group view1edu
     */
    public function TCView1EdukasiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'hafizhah@gmail.com')
                    ->type('password', 'hafizhah')
                    ->press('LOG IN')
                    ->assertSee('Konten Edukasi')
                    ->clickLink('Lihat Semua Konten Edukasi')
                    ->visit('/edukasi')
                    ->assertsee('Konten Edukasi');
        });
    }
}
