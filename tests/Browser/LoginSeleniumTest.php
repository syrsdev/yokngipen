<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginSeleniumTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_halaman_login_ditampilkan()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->assertVisible('input[name=email]')
                ->assertVisible('input[name=password]')
                ->assertSee('Log in');
        });
    }

    public function test_user_mengisi_form_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->type('email', 'user@example.com')
                ->type('password', 'Password123!')
                ->assertInputValue('email', 'user@example.com');
        });
    }

    public function test_login_admin_berhasil()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Password123!'),
            'phone' => '081234567890',
            'role' => 'admin',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->type('email', 'admin@example.com')
                ->type('password', 'Password123!')
                ->press('Log in')
                ->waitForLocation('/dashboard')
                ->assertPathIs('/dashboard');
        });
    }

    public function test_login_user_berhasil()
    {
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('Password123!'),
            'phone' => '081234567891',
            'role' => 'user',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->type('email', 'user@example.com')
                ->type('password', 'Password123!')
                ->press('Log in')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }

    public function test_login_gagal_password_salah()
    {
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('Password123!'),
            'phone' => '081234567892',
            'role' => 'user',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->type('email', 'user@example.com')
                ->type('password', 'SalahPassword')
                ->press('Log in')
                ->assertPathIs('/login');
        });
    }

    public function test_perbaiki_password_setelah_gagal_login()
    {
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('Password123!'),
            'phone' => '081234567893',
            'role' => 'user',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->type('email', 'user@example.com')
                ->type('password', 'SalahPassword')
                ->press('Log in')
                ->assertPathIs('/login')

                ->clear('password')
                ->type('password', 'Password123!')
                ->assertInputValue('email', 'user@example.com');
        });
    }

    public function test_redirect_dashboard_setelah_login_admin()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin2@example.com',
            'password' => bcrypt('Password123!'),
            'phone' => '081234567894',
            'role' => 'admin',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->type('email', 'admin2@example.com')
                ->type('password', 'Password123!')
                ->press('Log in')
                ->waitForLocation('/dashboard')
                ->assertPathIs('/dashboard');
        });
    }

    public function test_redirect_home_setelah_login_user()
    {
        User::factory()->create([
            'name' => 'User',
            'email' => 'user2@example.com',
            'password' => bcrypt('Password123!'),
            'phone' => '081234567895',
            'role' => 'user',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->type('email', 'user2@example.com')
                ->type('password', 'Password123!')
                ->press('Log in')
                ->waitForLocation('/')
                ->assertPathIs('/');
        });
    }
}
