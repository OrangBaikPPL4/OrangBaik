<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCMod1TestiTest extends DuskTestCase
{
    /**
     * @test
     * @group mod1testi
     */
    public function TCMod1TestiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'adminh@gmail.com')
                    ->type('password', 'adminadmin')
                    ->press('LOG IN')
                    ->visit('/testimoni')
                    ->assertsee('Bagikan Cerita dan Pengalaman Anda')
                    ->clickLink('Moderasi')
                    ->visit('/admin/testimoni/moderasi')
                    ->assertsee('Moderasi Testimoni')
                    ->click('.bg-green-200')
                    ->visit('/admin/testimoni/moderasi');
        });
    }
}
