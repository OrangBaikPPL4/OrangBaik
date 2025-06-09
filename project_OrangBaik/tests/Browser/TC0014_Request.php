<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC0014_Request extends DuskTestCase
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
                    ->select('sort_by', 'created_at');
        });
    }
}
