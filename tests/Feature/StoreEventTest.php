<?php

namespace Tests\Feature;

use App\Models\events;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// EP Kelas Valid – Path 1: Semua field valid, event berhasil dibuat
test('event berhasil dibuat dengan semua input valid', function () {
    // Arrange
    Storage::fake('public');
    $user = User::factory()->organizer()->create();

    // Act
    $response = $this->actingAs($user)->post(route('events.store'), [

        'title'          => 'FANMEETING Waras Group In Surabaya',
        'description'    => 'Deskripsi FANMEETING Waras Group',
        'location'       => 'Aula Telkom University Surabaya',
        'start_date'     => '2026-06-17',
        'end_date'       => '2026-06-19',
        'payment_method' => 'transfer',
        'account_number' => '123456789',
        'banner'         => UploadedFile::fake()->image('banner.jpg'),
        'name'           => 'Regular',
        'price'          => 850000,
        'quota'          => 150,
    ]);

    // Assert
    $response->assertRedirect(route('events.index'));
    $response->assertSessionHas('success', 'Event berhasil ditambahkan!');

    $this->assertDatabaseHas('events', [
        'title'  => 'FANMEETING Waras Group In Surabaya',
        'status' => 'draft',
    ]);

    $this->assertDatabaseHas('event_prices', [
        'name'  => 'Regular',
        'price' => 850000,
        'quota' => 150,
    ]);
});

// EP Kelas Invalid – Path 2: title kosong, validasi $credential gagal
test('event gagal dibuat jika title kosong', function () {
    // Arrange
    Storage::fake('public');
    $user = User::factory()->organizer()->create();

    // Act
    $response = $this->actingAs($user)->post(route('events.store'), [
        'title'          => '',
        'description'    => 'Deskripsi FANMEETING Waras Group',
        'location'       => 'Aula Telkom University Surabaya',
        'start_date'     => '2026-06-17',
        'end_date'       => '2026-06-19',
        'payment_method' => 'transfer',
        'account_number' => '123456789',
        'banner'         => UploadedFile::fake()->image('banner.jpg'),
        'name'           => 'Regular',
        'price'          => 850000,
        'quota'          => 150,
    ]);

    // Assert
    $response->assertSessionHasErrors('title');

    $this->assertDatabaseMissing('events', [
        'description' => 'Deskripsi event',
    ]);
});

// EP Kelas Invalid – Path 3: name tiket kosong, validasi $credential2 gagal
test('event gagal dibuat jika name tiket kosong', function () {
    // Arrange
    Storage::fake('public');
    $user = User::factory()->organizer()->create();

    // Act
    $response = $this->actingAs($user)->post(route('events.store'), [
        'title'          => 'FANMEETING Waras Group In Surabaya',
        'description'    => 'Deskripsi FANMEETING Waras Group',
        'location'       => 'Aula Telkom University Surabaya',
        'start_date'     => '2026-06-17',
        'end_date'       => '2026-06-19',
        'payment_method' => 'transfer',
        'account_number' => '1234567890',
        'banner'         => UploadedFile::fake()->image('banner.jpg'),
        'name'           => '',
        'price'          => '',
        'quota'          => '',
    ]);

    // Assert
    $response->assertSessionHasErrors('name');

    $this->assertDatabaseMissing('event_prices', [
        'name' => '',
    ]);
});