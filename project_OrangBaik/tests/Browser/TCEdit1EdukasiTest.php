<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCEdit1EdukasiTest extends DuskTestCase
{
    /**
     * @test
     * @group edit1edu
     */
    public function TCEdit1EdukasiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'adminh@gmail.com')
                    ->type('password', 'adminadmin')
                    ->press('LOG IN')
                    ->visit('/edukasi')
                    ->waitForText('Edit', 5)
                    ->clickLink('Edit')
                    ->type('title', 'Evakuasi Mandiri Saat Bencana')
                    ->type('content', 'Evakuasi saat adanya bencana')
                    ->select('category', 'Evakuasi')
                    ->press('Update')
                    ->visit('/admin/edukasi');
        });
    }
}
