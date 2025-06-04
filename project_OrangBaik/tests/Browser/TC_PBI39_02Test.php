<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PBI39_02Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testKirimFormKosong()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->press('Kirim Pertanyaan');
                    // ->assertSee('Harap isi pertanyaan');
        });
    }
}
