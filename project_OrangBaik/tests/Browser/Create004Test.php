<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Create004Test extends DuskTestCase
{
    /**
     * @group create4
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
            ->clickLink('Tambah Sekarang')
            ->assertPathIs('/admin/edukasi/create')
            ->assertSee('Buat Konten Edukasi')
            ->type('title', 'Evakuasi Gempa')
            ->select('Pilih Kategori', 'Evakuasi')
            ->press('
                Simpan Konten
            ');
        });
    }
}
