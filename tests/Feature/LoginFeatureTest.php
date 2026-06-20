<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('EP-01 organizer berhasil login dan redirect dashboard', function () {

    User::factory()->create([
        'email' => 'organizer@gmail.com',
        'password' => Hash::make('Password123'),
        'role' => 'organizer',
    ]);

    $this->post(route('login'), [
        'email' => 'organizer@gmail.com',
        'password' => 'Password123',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticated();
});

test('EP-02 user berhasil login dan redirect home', function () {

    User::factory()->create([
        'email' => 'user@gmail.com',
        'password' => Hash::make('Password123'),
        'role' => 'user',
    ]);

    $this->post(route('login'), [
        'email' => 'user@gmail.com',
        'password' => 'Password123',
    ])->assertRedirect(route('home'));

    $this->assertAuthenticated();
});

test('EP-03 format email tidak valid', function () {

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'organizergmail',
            'password' => 'Password123',
        ])
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('EP-04 email kosong', function () {

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => '',
            'password' => 'Password123',
        ])
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('EP-05 email tidak terdaftar', function () {

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'tidakada@gmail.com',
            'password' => 'Password123',
        ]);

    $this->assertGuest();
});

test('EP-06 password salah', function () {

    User::factory()->create([
        'email' => 'user@gmail.com',
        'password' => Hash::make('Password123'),
        'role' => 'user',
    ]);

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'user@gmail.com',
            'password' => 'Salah123',
        ]);

    $this->assertGuest();
});

test('EP-07 password kosong', function () {

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'user@gmail.com',
            'password' => '',
        ])
        ->assertSessionHasErrors('password');

    $this->assertGuest();
});
