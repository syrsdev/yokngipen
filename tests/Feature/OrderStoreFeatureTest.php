<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\events;
use App\Models\event_prices;

class OrderStoreFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
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

    private function createUser($email)
    {
        return User::create([
            'name' => 'Test',
            'email' => $email,
            'password' => bcrypt('pass'),
            'role' => 'user',
            'phone' => '081234567890'
        ]);
    }

    private function createEventPrice($eventId)
    {
        return event_prices::create([
            'events_id' => $eventId,
            'name' => 'Regular',
            'price' => 50000,
            'quota' => 10
        ]);
    }

    // EQUIVALENCE PARTITIONING (14 test)

    public function test_ep_valid_event_price_id()
    {
        $user = $this->createUser('ep1@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHas('success');
    }

    public function test_ep_invalid_event_price_id()
    {
        $user = $this->createUser('ep2@test.com');
        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => 99999,
            'quantity' => 1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('event_price_id');
    }

    public function test_ep_null_event_price_id()
    {
        $user = $this->createUser('ep3@test.com');
        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => null,
            'quantity' => 1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('event_price_id');
    }

    public function test_ep_non_integer_event_price_id()
    {
        $user = $this->createUser('ep4@test.com');
        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => 'abc',
            'quantity' => 1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('event_price_id');
    }

    public function test_ep_valid_quantity()
    {
        $user = $this->createUser('ep5@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 2,
            'payment_proof' => $file
        ]);

        $response->assertSessionHas('success');
    }

    public function test_ep_quantity_zero()
    {
        $user = $this->createUser('ep6@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 0,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('quantity');
    }

    public function test_ep_quantity_negative()
    {
        $user = $this->createUser('ep7@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => -1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('quantity');
    }

    public function test_ep_quantity_exceeds_quota()
    {
        $user = $this->createUser('ep8@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 11,
            'payment_proof' => $file
        ]);

        $response->assertStatus(500);
    }

    public function test_ep_quantity_non_integer()
    {
        $user = $this->createUser('ep9@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 1.5,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('quantity');
    }

    public function test_ep_quantity_non_numeric()
    {
        $user = $this->createUser('ep10@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 'dua',
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('quantity');
    }

    public function test_ep_valid_payment_proof()
    {
        $user = $this->createUser('ep11@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 500);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHas('success');
    }

    public function test_ep_invalid_extension_payment_proof()
    {
        $user = $this->createUser('ep12@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->create('proof.pdf', 500);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('payment_proof');
    }

    public function test_ep_oversized_payment_proof()
    {
        $user = $this->createUser('ep13@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);

        $file = UploadedFile::fake()->create('proof.jpg', 2049);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 1,
            'payment_proof' => $file
        ]);

        $response->assertSessionHasErrors('payment_proof');
    }

    public function test_ep_null_payment_proof()
    {
        $user = $this->createUser('ep14@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 1,
            'payment_proof' => null
        ]);

        $response->assertSessionHasErrors('payment_proof');
    }

    // STATE TRANSITION (5 test)

    public function test_state_transition_click_order_button()
    {
        $user = $this->createUser('st1@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);

        $response = $this->get('/events/' . $event->id);

        $response->assertStatus(200);
        $response->assertSee('Beli Tiket');
    }

    public function test_state_transition_fill_valid_form()
    {
        $user = $this->createUser('st2@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 2,
            'payment_proof' => $file
        ]);

        $response->assertRedirect();
    }

    public function test_state_transition_submit_valid_order()
    {
        $user = $this->createUser('st3@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('proof.jpg', 100);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 2,
            'payment_proof' => $file
        ]);

        $response->assertSessionHas('success', 'Tiket berhasil dipesan, menunggu verifikasi.');
    }

    public function test_state_transition_submit_invalid_order()
    {
        $user = $this->createUser('st4@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);

        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 0,
            'payment_proof' => null
        ]);

        $response->assertSessionHasErrors(['quantity', 'payment_proof']);
    }

    public function test_state_transition_fix_and_resubmit()
    {
        $user = $this->createUser('st5@test.com');
        $event = $this->createEvent();
        $ep = $this->createEventPrice($event->id);

        $this->actingAs($user);

        $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 0,
            'payment_proof' => null
        ]);

        $file = UploadedFile::fake()->image('proof.jpg', 100);
        $response = $this->post('/order', [
            'event_price_id' => $ep->id,
            'quantity' => 2,
            'payment_proof' => $file
        ]);

        $response->assertSessionHas('success');
    }
}
