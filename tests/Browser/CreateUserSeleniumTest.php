<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateUserSeleniumTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function loginSebagaiAdmin(Browser $browser): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $browser->loginAs($admin)->visit(route('users.index'));
    }

    protected function nonaktifkanValidasiBrowser(Browser $browser): void
    {
        $browser->script("document.querySelector('form').setAttribute('novalidate', 'novalidate');");
    }

    public function test_baris1_klik_tambah_user_menampilkan_form()
    {
        $this->browse(function (Browser $browser) {
            $this->loginSebagaiAdmin($browser);

            $browser->visit(route('users.create'))
                ->assertPathIs('/dashboard/users/add')
                ->assertVisible('input[name=name]')
                ->assertVisible('input[name=email]')
                ->assertVisible('input[name=phone]')
                ->assertVisible('input[name=password]')
                ->assertVisible('input[name=password_confirmation]')
                ->assertVisible('input[name=role][value=user]')
                ->assertVisible('input[name=role][value=organizer]');
        });
    }

    public function test_baris2_mengisi_semua_field_form()
    {
        $this->browse(function (Browser $browser) {
            $this->loginSebagaiAdmin($browser);

            $browser->visit(route('users.create'))
                ->type('name', 'John Doe')
                ->type('email', 'john@example.com')
                ->type('phone', '081234567890')
                ->radio('role', 'user')
                ->type('password', 'Password123!')
                ->type('password_confirmation', 'Password123!')
                ->assertInputValue('name', 'John Doe')
                ->assertInputValue('email', 'john@example.com')
                ->assertInputValue('phone', '081234567890')
                ->assertRadioSelected('role', 'user');
        });
    }

    public function test_baris3_submit_data_valid_user_berhasil_dibuat()
    {
        $this->browse(function (Browser $browser) {
            $this->loginSebagaiAdmin($browser);

            $browser->visit(route('users.create'))
                ->type('name', 'John Doe')
                ->type('email', 'john@example.com')
                ->type('phone', '081234567890')
                ->radio('role', 'user')
                ->type('password', 'Password123!')
                ->type('password_confirmation', 'Password123!')
                ->press('Simpan')
                ->waitForLocation('/dashboard/users')
                ->assertPathIs('/dashboard/users')
                ->assertSee('Tambah User berhasil!')
                ->assertSee('John Doe')
                ->assertSee('john@example.com');

            $this->assertDatabaseHas('users', [
                'email' => 'john@example.com',
                'name'  => 'John Doe',
            ]);
        });
    }

    public function test_baris4_submit_name_kosong_validasi_gagal()
    {
        $this->browse(function (Browser $browser) {
            $this->loginSebagaiAdmin($browser);

            $browser->visit(route('users.create'))
                ->type('name', '')
                ->type('email', 'syrs@example.com')
                ->type('phone', '081234567890')
                ->radio('role', 'user')
                ->type('password', 'Password123!')
                ->type('password_confirmation', 'Password123!');
            $this->nonaktifkanValidasiBrowser($browser);

            $browser->press('Simpan')
                ->assertPathIs('/dashboard/users/add')
                ->waitFor('.swal2-container', 10)   
                ->pause(300)                        
                ->assertSee('The name field is required.')
                ->assertSee('OK')
                ->press('OK')
                ->waitUntilMissing('.swal2-container', 10)
                ->pause(300);

            $this->assertDatabaseMissing('users', [
                'email' => 'syrs@example.com',
            ]);
        });
    }

    public function test_baris5_perbaiki_input_setelah_error_lalu_berhasil()
    {
        $this->browse(function (Browser $browser) {
            $this->loginSebagaiAdmin($browser);

            $browser->visit(route('users.create'))
                ->type('name', '')
                ->type('email', 'john@example.com')
                ->type('phone', '081298765432')
                ->radio('role', 'organizer')
                ->type('password', 'Password123!')
                ->type('password_confirmation', 'Password123!');

            $this->nonaktifkanValidasiBrowser($browser);
            $browser->press('Simpan')
                ->assertPathIs('/dashboard/users/add')
                ->waitFor('.swal2-container', 10)  
                ->pause(300)                         
                ->assertSee('The name field is required.')
                ->assertSee('The name field is required.')
                ->assertSee('OK')
                ->press('OK')
                ->waitUntilMissing('.swal2-container', 10)   
                ->pause(300)                                 

                ->clear('name')
                ->type('name', 'johny')
                ->type('password', 'Password123!')
                ->type('password_confirmation', 'Password123!')
                ->press('Simpan')
                ->waitForLocation('/dashboard/users')
                ->assertPathIs('/dashboard/users')
                ->assertSee('Tambah User berhasil!')
                ->assertSee('johny');

            $this->assertDatabaseHas('users', [
                'email' => 'john@example.com',
            ]);
        });
    }

    public function test_baris6_list_user_terupdate_setelah_create()
    {
        $this->browse(function (Browser $browser) {
            $this->loginSebagaiAdmin($browser);

            $browser->visit(route('users.index'));

            $browser->visit(route('users.create'))
                ->type('name', 'Budi Santoso')
                ->type('email', 'budi@example.com')
                ->type('phone', '081200001111')
                ->radio('role', 'user')
                ->type('password', 'Password123!')
                ->type('password_confirmation', 'Password123!')
                ->press('Simpan')
                ->waitForLocation('/dashboard/users');


            $browser->assertSee('Budi Santoso')
                ->assertSee('budi@example.com');
        });
    }
}