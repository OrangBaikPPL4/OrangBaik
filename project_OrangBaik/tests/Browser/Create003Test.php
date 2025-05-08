<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Create003Test extends DuskTestCase
{
    /**
     * @group create3
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
            ->type('content', 'Berikut adalah cara evakuasi korban gempa')
            ->select('Pilih Kategori', 'Evakuasi')
            ->press('
                Simpan Konten
            ');
        });
    }
}
