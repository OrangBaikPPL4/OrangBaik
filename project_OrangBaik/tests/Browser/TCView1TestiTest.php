<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCView1TestiTest extends DuskTestCase
{
    /**
     * @test
     * @group view1testi
     */
    public function TCView1TestiTest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'hafizhah@gmail.com')
                    ->type('password', 'hafizhah')
                    ->press('LOG IN')
                    ->visit('/testimoni')
                    ->assertSee('Bagikan Cerita dan Pengalaman Anda')
                    ->clickLink('Detail')
                    ->visit('/testimoni/4');
        });
    }
}
