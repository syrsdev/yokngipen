<?php

use App\Models\User;
use App\Models\events;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

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

function validData(array $override = [])
{
    return array_merge([
        'title' => 'FANMEETING Waras Group In Surabaya',
        'description' => 'Deskripsi FANMEETING Waras Group',
        'location' => 'Aula Telkom University Surabaya',
        'start_date' => '2026-06-17',
        'end_date' => '2026-06-19',
        'payment_method' => 'transfer',
        'account_number' => '123456789',
        'banner' => UploadedFile::fake()->image('banner.jpg'),
        'name' => 'Regular',
        'price' => 850000,
        'quota' => 150,
    ], $override);
}

test('UT-01 path P1 seluruh input valid maka event berhasil dibuat', function () {
    Storage::fake('public');

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validData());

    $response->assertRedirect(route('events.index'));

    expect(events::count())->toBe(1);
});

test('UT-02 path P3 title kosong maka validasi credential pertama gagal', function () {
    actingAsOrganizer();

    $response = $this->post(route('events.store'), validData([
        'title' => '',
    ]));

    $response->assertSessionHasErrors(['title']);
});

test('UT-03 path P4 name tiket kosong maka validasi credential kedua gagal', function () {
    actingAsOrganizer();

    $response = $this->post(route('events.store'), validData([
        'name' => '',
    ]));

    $response->assertSessionHasErrors(['name']);
});

test('UT-04 event berhasil disimpan dengan status draft', function () {
    Storage::fake('public');

    actingAsOrganizer();

    $response = $this->post(route('events.store'), validData());

    dump('Status code: ' . $response->status());
    if ($response->status() === 500) {
        dump('Exception: ' . $response->exception?->getMessage());
        dump('File: ' . $response->exception?->getFile() . ':' . $response->exception?->getLine());
    }

    $this->assertDatabaseHas('events', [
        'title' => 'FANMEETING Waras Group In Surabaya',
        'status' => 'draft',
    ]);
});