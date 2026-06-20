<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\events;
use App\Models\event_prices;

class OrderStoreUnitTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    private function createEvent()
    {
        $organizer = User::create([
            'name' => 'Organizer',
            'email' => 'org' . uniqid() . '@test.com',
            'password' => bcrypt('pass'),
            'role' => 'organizer',
            'phone' => '081234567890'
        ]);

        return events::create([
            'title' => 'Event Test',
            'description' => 'Desc',
            'location' => 'Surabaya',
            'start_date' => '2026-06-17 00:00:00',
            'end_date' => '2026-06-19 00:00:00',
            'payment_method' => 'transfer',
            'account_number' => '1234567890',
            'status' => 'published',
            'banner' => 'banner.jpg',
            'id_organizer' => $organizer->id
        ]);
    }

    // PATH 1: Validasi gagal (input kosong)
    public function test_path_1_validation_fails()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'p1@test.com',
            'password' => bcrypt('pass'),
            'role' => 'user',
            'phone' => '081234567890'
        ]);

        $this->actingAs($user);

        $response = $this->post('/order', [
            'event_price_id' => null,
            'quantity' => 0,
            'payment_proof' => null
        ]);

        $response->assertSessionHasErrors(['event_price_id', 'quantity', 'payment_proof']);
    }

    // PATH 2: ID event tidak ditemukan
    public function test_path_2_event_price_not_found()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'p2@test.com',
            'password' => bcrypt('pass'),
            'role' => 'user',
            'phone' => '081234567890'
        ]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => 99999,
            'quantity' => 1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors();
    }

    // PATH 3: Quota tidak mencukupi - FIX: assertStatus(500)
    public function test_path_3_quota_exceeded()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'p3@test.com',
            'password' => bcrypt('pass'),
            'role' => 'user',
            'phone' => '081234567890'
        ]);

        $event = $this->createEvent();
        $eventPrice = event_prices::create([
            'events_id' => $event->id,
            'name' => 'Regular',
            'price' => 50000,
            'quota' => 10
        ]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $eventPrice->id,
            'quantity' => 11,
            'payment_proof' => $file
        ]);

        // FIX: Exception di transaction = 500 error
        $response->assertStatus(500);
    }

    // PATH 4: Semua valid - berhasil
    public function test_path_4_order_success()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'p4@test.com',
            'password' => bcrypt('pass'),
            'role' => 'user',
            'phone' => '081234567890'
        ]);

        $event = $this->createEvent();
        $eventPrice = event_prices::create([
            'events_id' => $event->id,
            'name' => 'Regular',
            'price' => 50000,
            'quota' => 10
        ]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $eventPrice->id,
            'quantity' => 2,
            'payment_proof' => $file
        ]);

        $response->assertSessionHas('success', 'Tiket berhasil dipesan, menunggu verifikasi.');

        $this->assertDatabaseHas('orders', [
            'id_event_price' => $eventPrice->id,
            'quantity' => 2,
            'id_user' => $user->id,
            'status' => 'pending'
        ]);
    }
}
