<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class View001Test extends DuskTestCase
{
    /**
     * @group view1
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->assertSee('Bersama, Kita Bisa Membantu')
            ->select(' Masuk / Buat Akun ', 'Masuk')
            ->assertPathIs('/login')
            ->type('email', 'hafizhah@gmail.com')
            ->type('password', 'hafizhah')
            ->press('LOG IN')
            ->visit('/dashboard')
            ->assertSee('Dashboard')
            ->clickLink('Lihat Selengkapnya')
            ->assertPathIs('/edukasi/5')
            ->assertSee('Siapkan Tas Siaga Bencana')
            ->select('Semua', 'Evakuasi')
            ->assertPathIs('/edukasi/5?category=evakuasi');
        });
    }
}
