<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCView2TestiTest extends DuskTestCase
{
    /**
     * @test
     * @group view2testi
     */
    public function TCView2TestiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'hafizhah@gmail.com')
                    ->type('password', 'hafizhah')
                    ->press('LOG IN')
                    ->visit('/testimoni')
                    ->assertSee('Bagikan Cerita dan Pengalaman Anda')
                    ->select('jenis_bencana', 'GEMPA BUMI')
                    ->press('FILTER')
                    ->visit('/testimoni?lokasi=&jenis_bencana=Gempa+Bumi&search=');
        });
    }
}
