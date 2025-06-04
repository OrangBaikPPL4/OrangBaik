<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC0013_Request extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'pradip@gmail.com')
                    ->type('password', '12345678')
                    ->press('LOG IN')
                    ->clickLink('Request')
                    ->select('jenis_kebutuhan', 'makanan');
        });
    }
}
