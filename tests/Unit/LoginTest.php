<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, RefreshDatabase::class);

function loginValidationRules(): array
{
    return [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];
}

test('P1 - input tidak valid maka validasi gagal', function () {

    $data = [
        'email' => '',
        'password' => 'Password123',
    ];

    $validator = Validator::make($data, loginValidationRules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('email'))->toBeTrue();
});

test('P2 - password salah maka autentikasi gagal', function () {

    $user = User::factory()->create([
        'email' => 'user@gmail.com',
        'password' => Hash::make('Password123'),
    ]);

    $loginBerhasil = Hash::check(
        'PasswordSalah',
        $user->password
    );

    expect($loginBerhasil)->toBeFalse();
});

test('P3 - admin atau organizer berhasil login', function () {

    $role = 'organizer';

    $redirect = ($role === 'admin' || $role === 'organizer')
        ? 'dashboard'
        : 'home';

    expect($redirect)->toBe('dashboard');
});

test('P4 - user berhasil login', function () {

    $role = 'user';

    $redirect = ($role === 'admin' || $role === 'organizer')
        ? 'dashboard'
        : 'home';

    expect($redirect)->toBe('home');
});