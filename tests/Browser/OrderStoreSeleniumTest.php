<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\events;
use App\Models\event_prices;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OrderStoreSeleniumTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected string $dummyProofPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dummyProofPath = base_path('tests/Browser/dummy_proof.jpg');
    }

    protected function loginSebagaiUser(Browser $browser): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'phone' => '081234567890'
        ]);
        $browser->loginAs($user);
    }

    protected function buatEventDanHarga(): array
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        $event = events::create([
            'title' => 'Event Test',
            'description' => 'Deskripsi event',
            'location' => 'Surabaya',
            'start_date' => '2026-06-17 00:00:00',
            'end_date' => '2026-06-19 00:00:00',
            'payment_method' => 'transfer',
            'account_number' => '1234567890',
            'status' => 'published',
            'banner' => 'banner.jpg',
            'id_organizer' => $organizer->id
        ]);

        $eventPrice = event_prices::create([
            'events_id' => $event->id,
            'name' => 'Regular',
            'price' => 50000,
            'quota' => 10
        ]);

        return [$event, $eventPrice];
    }

    public function test_baris1_klik_beli_tiket_menampilkan_form()
    {
        [$event, $eventPrice] = $this->buatEventDanHarga();

        $this->browse(function (Browser $browser) use ($event) {
            $this->loginSebagaiUser($browser);

            $browser->visit('/events/' . $event->id)
                ->assertSee('Event Test')
                ->assertSee('Beli Tiket')
                ->press('Beli Tiket')
                ->assertPathIs('/events/' . $event->id)
                ->assertVisible('select[name=event_price_id]')
                ->assertVisible('input[name=quantity]')
                ->assertVisible('input[name=payment_proof]');
        });
    }

    public function test_baris2_mengisi_semua_field_form()
    {
        [$event, $eventPrice] = $this->buatEventDanHarga();

        $this->browse(function (Browser $browser) use ($event, $eventPrice) {
            $this->loginSebagaiUser($browser);

            $browser->visit('/events/' . $event->id)
                ->press('Beli Tiket')
                ->select('event_price_id', $eventPrice->id)
                ->type('quantity', '2')
                ->attach('payment_proof', $this->dummyProofPath)
                ->assertInputValue('quantity', '2');
        });
    }


    public function test_baris3_submit_data_valid_order_tersimpan()
    {
        [$event, $eventPrice] = $this->buatEventDanHarga();

        $this->browse(function (Browser $browser) use ($event, $eventPrice) {
            $this->loginSebagaiUser($browser);

            $browser->visit('/events/' . $event->id)
                ->press('Beli Tiket')
                ->waitFor('select[name="event_price_id"]', 5)
                ->select('event_price_id', $eventPrice->id)
                ->type('quantity', '2')
                ->attach('payment_proof', $this->dummyProofPath)
                ->press('Beli Tiket')
                ->pause(2000)
                ->assertPathIs('/events/' . $event->id)
                ->assertSee('Tiket berhasil dipesan, menunggu verifikasi.');

            $this->assertDatabaseHas('orders', [
                'id_event_price' => $eventPrice->id,
                'quantity' => 2,
                'status' => 'pending'
            ]);
        });
    }


    public function test_baris4_submit_quantity_kosong_validasi_gagal()
    {
        [$event, $eventPrice] = $this->buatEventDanHarga();

        $this->browse(function (Browser $browser) use ($event, $eventPrice) {
            $this->loginSebagaiUser($browser);

            $browser->visit('/events/' . $event->id)
                ->press('Beli Tiket')
                ->select('event_price_id', $eventPrice->id)
                ->type('quantity', '0')
                ->press('Beli Tiket')
                ->assertPathIs('/events/' . $event->id);

            $this->assertDatabaseMissing('orders', [
                'id_event_price' => $eventPrice->id,
            ]);
        });
    }


    public function test_baris5_perbaiki_input_setelah_error_lalu_berhasil()
    {
        [$event, $eventPrice] = $this->buatEventDanHarga();

        $this->browse(function (Browser $browser) use ($event, $eventPrice) {
            $this->loginSebagaiUser($browser);

            $browser->visit('/events/' . $event->id)
                ->press('Beli Tiket')
                ->waitFor('select[name="event_price_id"]', 5)
                ->select('event_price_id', $eventPrice->id)
                ->type('quantity', '0')
                ->press('Beli Tiket')
                ->pause(1000)
                ->assertPathIs('/events/' . $event->id);

            $browser->refresh()
                ->assertPathIs('/events/' . $event->id)
                ->press('Beli Tiket')
                ->waitFor('select[name="event_price_id"]', 5);

            $browser->select('event_price_id', $eventPrice->id)
                ->type('quantity', '2')
                ->attach('payment_proof', $this->dummyProofPath)
                ->press('Beli Tiket')
                ->pause(2000)
                ->assertPathIs('/events/' . $event->id);

            $this->assertDatabaseHas('orders', [
                'id_event_price' => $eventPrice->id,
                'quantity' => 2,
            ]);
        });
    }


    public function test_baris6_list_tiket_terupdate_setelah_order()
    {
        [$event, $eventPrice] = $this->buatEventDanHarga();

        $this->browse(function (Browser $browser) use ($event, $eventPrice) {
            $this->loginSebagaiUser($browser);

            $browser->visit('/events/' . $event->id)
                ->press('Beli Tiket')
                ->waitFor('select[name="event_price_id"]', 5)
                ->select('event_price_id', $eventPrice->id)
                ->type('quantity', '3')
                ->attach('payment_proof', $this->dummyProofPath)
                ->press('Beli Tiket')
                ->pause(2000)
                ->assertPathIs('/events/' . $event->id);


            $browser->visit('/my-tickets')
                ->assertSee('Event Test')
                ->assertSee('Regular');
        });
    }
}
