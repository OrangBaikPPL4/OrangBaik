<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FaqManagementTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Buat user admin
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }

    /** @test */
    public function user_can_see_faq_list_on_public_page()
    {
        $faq = Faq::create([
            'question' => 'Apa itu OrangBaik?',
            'answer' => 'OrangBaik adalah platform untuk berbagi dan berdonasi.'
        ]);

        $this->browse(function (Browser $browser) use ($faq) {
            $browser->visit('/faq')
                    ->assertSee('Pertanyaan yang Sering Diajukan')
                    ->assertSee($faq->question)
                    ->assertSee($faq->answer);
        });
    }

    /** @test */
    public function admin_can_add_new_faq()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/dashboard') // ubah sesuai dashboard admin
                    ->visit('/admin/faq') // ubah ke URL manajemen FAQ
                    ->clickLink('Tambah FAQ')
                    ->type('question', 'Bagaimana cara berdonasi?')
                    ->type('answer', 'Anda dapat berdonasi melalui halaman campaign.')
                    ->press('Simpan') // pastikan tombol submit ada dan sesuai
                    ->assertPathIs('/admin/faq')
                    ->assertSee('Bagaimana cara berdonasi?')
                    ->assertSee('Anda dapat berdonasi melalui halaman campaign.');
        });
    }

    /** @test */
    public function admin_can_edit_and_delete_faq()
    {
        $faq = Faq::create([
            'question' => 'Pertanyaan awal?',
            'answer' => 'Jawaban awal.'
        ]);

        $this->browse(function (Browser $browser) use ($faq) {
            $browser->visit('/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->visit('/admin/faq')
                    ->clickLink('Edit')
                    ->type('question', 'Pertanyaan yang sudah diedit?')
                    ->type('answer', 'Jawaban yang sudah diperbarui.')
                    ->press('Simpan')
                    ->assertPathIs('/admin/faq')
                    ->assertSee('Pertanyaan yang sudah diedit?')
                    ->assertSee('Jawaban yang sudah diperbarui.')

                    // Hapus FAQ
                    ->press('Hapus') // pastikan tombol ini ada dan tidak terganggu JavaScript
                    ->whenAvailable('form', function ($form) {
                        $form->press('Hapus');
                    })
                    ->assertDontSee('Pertanyaan yang sudah diedit?');
        });
    }
}
