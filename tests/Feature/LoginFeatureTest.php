<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('P1 - input tidak valid', function () {

    $this->post('/login', [
        'email' => '',
        'password' => 'Password123',
    ])
    ->assertSessionHasErrors('email');
});

test('P2 - login gagal karena password salah', function () {

    User::factory()->create([
        'email' => 'user@gmail.com',
        'password' => Hash::make('Password123'),
        'role' => 'user',
    ]);

    $this->post('/login', [
        'email' => 'user@gmail.com',
        'password' => 'PasswordSalah',
    ])
    ->assertSessionHasErrors();
});

test('P3 - admin atau organizer berhasil login', function () {

    User::factory()->create([
        'email' => 'organizer@gmail.com',
        'password' => Hash::make('Password123'),
        'role' => 'organizer',
    ]);

    $this->post('/login', [
        'email' => 'organizer@gmail.com',
        'password' => 'Password123',
    ])
    ->assertRedirect(route('dashboard'));
});

test('P4 - user berhasil login', function () {

    User::factory()->create([
        'email' => 'user@gmail.com',
        'password' => Hash::make('Password123'),
        'role' => 'user',
    ]);

    $this->post('/login', [
        'email' => 'user@gmail.com',
        'password' => 'Password123',
    ])
    ->assertRedirect(route('home'));
});
