<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Create001Test extends DuskTestCase
{
    /**
     * @group create1
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
                    ->visit('/admin/dashboard')
                    ->assertSee('Dashboard Admin')
                    ->clickLink('Tambah Sekarang')
                    ->assertPathIs('/admin/edukasi/create')
                    ->assertSee('Buat Konten Edukasi')
                    ->type('title', 'Evakuasi Gempa')
                    ->type('content', 'Berikut adalah cara evakuasi korban gempa')
                    ->select('Pilih Kategori', 'Evakuasi')
                    ->press('
                        Simpan Konten
                    ')
                    ->assertPathIs('/admin/edukasi')
                    ->assertSee('Daftar Konten Edukasi');
        });
    }
}
