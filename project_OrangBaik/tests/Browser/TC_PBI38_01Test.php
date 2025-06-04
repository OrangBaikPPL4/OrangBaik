<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PBI38_01Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testAdminMenambahkanFAQ()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@orangbaik.com')
                    ->type('password', 'password')
                    ->press('LOG IN')
                    ->visit('/admin/faq')
                    ->clickLink('Tambah FAQ')
                    ->type('question', 'Bagaimana cara berdonasi?')
                    ->type('answer', 'Anda bisa berdonasi melalui menu Donasi.')
                    ->press('SIMPAN')
                    ->assertPathIs('/admin/faq')
                    ->assertSee('Bagaimana cara berdonasi?');
        });
    }
}
