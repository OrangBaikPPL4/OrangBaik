<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCView2EdukasiTest extends DuskTestCase
{
    /**
     * @test
     * @group view2edu
     */
    public function TCView2EdukasiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'hafizhah@gmail.com')
                    ->type('password', 'hafizhah')
                    ->press('LOG IN')
                    ->assertSee('Konten Edukasi')
                    ->clickLink('Lihat Semua Konten Edukasi')
                    ->visit('/edukasi')
                    ->assertsee('Konten Edukasi')
                    ->select('category', 'Evakuasi')
                    ->press('Filter')
                    ->visit('/edukasi?category=evakuasi&search=');
        });
    }
}
