<?php

use App\Models\User;
use App\Models\events;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

function actingAsOrganizer()
{
    $organizer = User::create([
        'name' => 'Organizer',
        'email' => 'organizer@test.com',
        'password' => bcrypt('password'),
        'phone' => '081234567890',
        'role' => 'organizer',
    ]);

    return test()->actingAs($organizer);
}

function validEventData(array $overrides = []): array
{
    return array_merge([
        'title' => 'FANMEETING Waras Group In Surabaya',
        'description' => 'Deskripsi FANMEETING Waras Group',
        'location' => 'Aula Telkom University Surabaya',
        'start_date' => '2026-06-17',
        'end_date' => '2026-06-19',
        'payment_method' => 'transfer',
        'account_number' => '123456789',
        'banner' => UploadedFile::fake()->image('banner.jpg')->size(500),
        'name' => 'Regular',
        'price' => 850000,
        'quota' => 150,
    ], $overrides);
}

test('EP-01 seluruh input valid maka event berhasil dibuat', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData());

    $response
        ->assertRedirect(route('events.index'))
        ->assertSessionHas('success', 'Event berhasil ditambahkan!');

    $this->assertDatabaseHas('events', [
        'title' => 'FANMEETING Waras Group In Surabaya',
        'status' => 'draft',
    ]);

    $this->assertDatabaseHas('event_prices', [
        'name' => 'Regular',
        'price' => 850000,
        'quota' => 150,
    ]);
});

test('EP-02 title kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'title' => '',
    ]));

    $response->assertSessionHasErrors('title');

    expect(events::count())->toBe(0);
});

test('EP-03 description kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'description' => '',
    ]));

    $response->assertSessionHasErrors('description');

    expect(events::count())->toBe(0);
});

test('EP-04 location kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'location' => '',
    ]));

    $response->assertSessionHasErrors('location');

    expect(events::count())->toBe(0);
});

test('EP-05 start_date kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'start_date' => '',
    ]));

    $response->assertSessionHasErrors('start_date');

    expect(events::count())->toBe(0);
});

test('EP-06 end_date kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'end_date' => '',
    ]));

    $response->assertSessionHasErrors('end_date');

    expect(events::count())->toBe(0);
});

test('EP-07 payment_method kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'payment_method' => '',
    ]));

    $response->assertSessionHasErrors('payment_method');

    expect(events::count())->toBe(0);
});

test('EP-08 account_number kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'account_number' => '',
    ]));

    $response->assertSessionHasErrors('account_number');

    expect(events::count())->toBe(0);
});

test('EP-09 banner tidak diupload maka validasi error required', function () {

    actingAsOrganizer();

    $data = validEventData();
    unset($data['banner']);

    $response = $this->post(route('events.store'), $data);

    $response->assertSessionHasErrors('banner');

    expect(events::count())->toBe(0);
});

test('EP-10 banner bukan gambar maka validasi error image', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'banner' => UploadedFile::fake()->create('dokumen.pdf', 500),
    ]));

    $response->assertSessionHasErrors('banner');

    expect(events::count())->toBe(0);
});

test('EP-11 ukuran banner melebihi 2048 KB maka validasi error max', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'banner' => UploadedFile::fake()->image('besar.jpg')->size(5000),
    ]));

    $response->assertSessionHasErrors('banner');

    expect(events::count())->toBe(0);
});

test('EP-12 name tiket kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'name' => '',
    ]));

    $response->assertSessionHasErrors('name');

    expect(events::count())->toBe(0);
});

test('EP-13 price kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'price' => '',
    ]));

    $response->assertSessionHasErrors('price');

    expect(events::count())->toBe(0);
});

test('EP-14 quota kosong maka validasi error required', function () {

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validEventData([
        'quota' => '',
    ]));

    $response->assertSessionHasErrors('quota');

    expect(events::count())->toBe(0);
});
//