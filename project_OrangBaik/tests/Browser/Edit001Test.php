<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Edit001Test extends DuskTestCase
{
    /**
     * @group edit1
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->assertSee('Bersama, Kita Bisa Membantu')
            ->select(' Masuk / Buat Akun ', 'Masuk')
            ->assertPathIs('/login')
            ->type('email', 'adminh@gmail.com')
            ->type('password', 'adminadmin')
            ->press('LOG IN')
            ->assertPathIs('/admin/dashboard')
            ->assertSee('Dashboard Admin')
            ->clickLink('Buka Halaman')
            ->assertPathIs('/admin/edukasi')
            ->assertSee('Daftar Konten Edukasi')
            ->clickLink('Edit')
            ->assertPathIs('/admin/edukasi/1/edit')
            ->assertSee('Edit Konten Edukasi')
            ->type('title', 'Evakuasi')
            ->type('content', 'Ini evakuasi')
            ->press('
                    Update
                ')
            ->assertPathIs('/admin/edukasi')
            ->assertSee('Daftar Konten Edukasi');
        });
    }
}
