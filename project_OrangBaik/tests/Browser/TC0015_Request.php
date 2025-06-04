<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC0015_Request extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser, Browser $adminBrowser) {
            $browser->visit('/login')
                    ->type('email', 'pradiptamuhtadin@gmail.com')
                    ->type('password', '12345678')
                    ->press('LOG IN')
                    ->visit('/request-bantuan/create')
                    ->select('jenis_kebutuhan', 'makanan')
                    ->type('deskripsi', 'Makanan untuk korban')
                    ->press('Ajukan Permintaan');
            $adminBrowser->visit('/login')
                    ->type('email', 'pradip@gmail.com')
                    ->type('password', '12345678')
                    ->press('LOG IN')
                    ->visit('/admin/notifications')
                    ->assertSee('Permintaan Bantuan Baru');
        });
    }
}
