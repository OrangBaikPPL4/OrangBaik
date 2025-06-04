<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PBI37_01Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testMelihatDaftarFAQ()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Temukan jawaban dari pertanyaan umum seputar platform OrangBaik.');
        });
    }
}
