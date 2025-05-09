<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Delete001Test extends DuskTestCase
{
    /**
     * @group delete
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
            ->clickLink('Hapus')
            ->assertPathIs('/admin/edukasi/1/edit')
            ->assertSee('Yakin ingin menghapus konten ini?')
            ->type('title', 'Evakuasi')
            ->type('content', 'Ini evakuasi')
            ->press('OK')
            ->assertPathIs('/admin/edukasi');
        });
    }
}
