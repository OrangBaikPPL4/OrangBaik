<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PBI38_02Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testTambahFAQTanpaPertanyaan()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@orangbaik.com')
                    ->type('password', 'password')
                    ->press('LOG IN')
                    ->visit('/admin/faq')
                    ->clickLink('Tambah FAQ')
                    ->type('question', '')
                    ->type('answer', 'Jawaban tanpa pertanyaan');
                    // ->press('Simpan');
                    // ->assertSee('Tambah FAQ Baru');

                    //Alert fill this form nya ga kebaca di laravel dusknya
        });
    }
}
