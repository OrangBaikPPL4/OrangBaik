<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DisasterReportTestTC001 extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function user_can_submit_complete_disaster_report()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/disaster-reports/create')
                ->type('Lokasi', 'Jl. Mawar No. 123')
                ->select('Jenis Bencana', 'Banjir')
                ->type('Deskripsi', 'Air meluap akibat hujan deras')
                ->attach('Bukti Media (Foto/Video)', __DIR__.'/files/foto_banjir.jpg')
                ->press('Kirim Laporan')
                ->assertPathIs('/disaster-reports');
        });
    }
}
