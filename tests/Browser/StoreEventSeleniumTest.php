<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StoreEventSeleniumTest extends DuskTestCase
{
    use DatabaseMigrations;

    private function buatOrganizer(): User
    {
        return User::create([
            'name'     => 'Organizer',
            'email'    => 'organizer@test.com',
            'password' => bcrypt('password'),
            'phone'    => '081234567890',
            'role'     => 'organizer',
        ]);
    }

    private function isiFormLengkap(Browser $browser, array $overrides = []): void
{
    $data = array_merge([
        'title'          => 'FANMEETING Waras Group In Surabaya',
        'description'    => 'Deskripsi FANMEETING Waras Group',
        'location'       => 'Aula Telkom University Surabaya',
        'start_date'     => '2026-06-17T10:00',
        'end_date'       => '2026-06-19T17:00',
        'payment_method' => 'transfer',
        'account_number' => '123456789',
        'name'           => 'Regular',
        'price'          => '850000',
        'quota'          => '150',
    ], $overrides);

    $browser->type('title', $data['title'])
        ->type('description', $data['description'])
        ->type('location', $data['location']);

    $browser->script("document.querySelector('[name=start_date]').value = '" . $data['start_date'] . "';");
    $browser->script("document.querySelector('[name=end_date]').value = '" . $data['end_date'] . "';");


    $browser->type('payment_method', $data['payment_method'])
        ->type('account_number', $data['account_number'])
        ->attach('banner', base_path('tests/Browser/fixtures/banner.jpg'))
        ->type('name', $data['name'])
        ->type('price', $data['price'])
        ->type('quota', $data['quota']);
}

    public function test_EP01_seluruh_input_valid_event_berhasil_dibuat(): void
    {
        $organizer = $this->buatOrganizer();

        $this->browse(function (Browser $browser) use ($organizer) {
            $browser->loginAs($organizer)
                ->visit('/dashboard/events/add');

            $this->isiFormLengkap($browser);

            $browser->press('Buat')
            ->pause(2000)
            ->screenshot('ep01-setelah-submit');

        $browser->waitForLocation('/dashboard/events', 15)
            ->assertSee('Event berhasil ditambahkan!');
        });

        $this->assertDatabaseHas('events', [
            'title'  => 'FANMEETING Waras Group In Surabaya',
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('event_prices', [
            'name'  => 'Regular',
            'price' => 850000,
            'quota' => 150,
        ]);
    }

    public function test_EP02_title_kosong_validasi_error_required(): void
{
    $organizer = $this->buatOrganizer();

    $this->browse(function (Browser $browser) use ($organizer) {
        $browser->loginAs($organizer)
            ->visit('/dashboard/events/add');

        $this->isiFormLengkap($browser, ['title' => '']);

        $browser->script("document.querySelectorAll('[required]').forEach(el => el.removeAttribute('required'));");


        $browser->press('Buat')
            ->waitForText('The title field is required.', 15)
            ->assertSee('The title field is required.');
    });

    $this->assertDatabaseCount('events', 0);
}

    public function test_EP09_banner_tidak_diupload_validasi_error_required(): void
    {
        $organizer = $this->buatOrganizer();

        $this->browse(function (Browser $browser) use ($organizer) {
            $browser->loginAs($organizer)
                ->visit('/dashboard/events/add')
                ->type('title', 'FANMEETING Waras Group In Surabaya')
                ->type('description', 'Deskripsi FANMEETING Waras Group')
                ->type('location', 'Aula Telkom University Surabaya')
                ->type('start_date', '2026-06-17T10:00')
                ->type('end_date', '2026-06-19T17:00')
                ->type('payment_method', 'transfer')
                ->type('account_number', '123456789')
                ->type('name', 'Regular')
                ->type('price', '850000')
                ->type('quota', '150')
                ->press('Buat')
                ->waitForText('The banner field is required.')
                ->assertSee('The banner field is required.');
        });

        $this->assertDatabaseCount('events', 0);
    }

    public function test_EP10_banner_bukan_gambar_validasi_error_image(): void
    {
        $organizer = $this->buatOrganizer();

        $this->browse(function (Browser $browser) use ($organizer) {
            $browser->loginAs($organizer)
                ->visit('/dashboard/events/add');

            $this->isiFormLengkap($browser);

            $browser->attach('banner', base_path('tests/Browser/fixtures/dokumen.pdf'))
                ->press('Buat')
                ->waitForText('The banner field must be an image.')
                ->assertSee('The banner field must be an image.');
        });

        $this->assertDatabaseCount('events', 0);
    }

    public function test_EP12_name_tiket_kosong_validasi_error_required(): void {
    $organizer = $this->buatOrganizer();

    $this->browse(function (Browser $browser) use ($organizer) {
        $browser->loginAs($organizer)
            ->visit('/dashboard/events/add');

        $this->isiFormLengkap($browser, ['name' => '']);

        $browser->script("document.querySelectorAll('[required]').forEach(el => el.removeAttribute('required'));");


        $browser->press('Buat')
            ->waitForText('The name field is required.', 15)
            ->assertSee('The name field is required.');
    });

    $this->assertDatabaseCount('events', 0);
}

}