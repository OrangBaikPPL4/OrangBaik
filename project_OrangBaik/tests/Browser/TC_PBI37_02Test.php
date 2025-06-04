<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\DB;


class TC_PBI37_02Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testPesanJikaFAQKosong()
    {
        $this->browse(function (Browser $browser) {
            // Temporarily remove all FAQs for this test
            $originalFaqs = DB::table('faqs')->get();
            DB::table('faqs')->delete();

            $browser
                ->visit('/')
                ->assertSee('Pertanyaan yang Sering Diajukan')
                ->assertSee('Tidak ada FAQ yang tersedia saat ini.');

            // Restore original FAQs
            foreach ($originalFaqs as $faq) {
                $faqArray = (array)$faq;
                if (isset($faqArray['id'])) {
                    unset($faqArray['id']); // Remove ID to let DB auto-increment
                }
                DB::table('faqs')->insert($faqArray);
            }
        });
    }
}
