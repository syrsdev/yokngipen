<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

uses(Tests\TestCase::class, RefreshDatabase::class);

function unitValidationRules(): array
{
    return [
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'string', 'lowercase', 'email', 'max:255'],
        'password' => ['required', 'confirmed', Password::min(8)],
        'phone'    => ['required', 'string', 'max:20'],
        'role'     => ['required', 'in:user,organizer'],
    ];
}

test('P1 - semua input valid maka user berhasil dibuat di database', function () {

    $data = [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'Password123!',
        'password_confirmation' => 'Password123!',
        'phone'                 => '081234567890',
        'role'                  => 'user',
    ];

    $validator = Validator::make($data, unitValidationRules());

    if (!$validator->fails()) {
        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'],
            'role'     => $data['role'],
        ]);
    }

    expect($validator->fails())->toBeFalse();
    expect(User::where('email', 'john@example.com')->exists())->toBeTrue();
    expect(User::count())->toBe(1);

    $user = User::first();
    expect($user->name)->toBe('John Doe');
    expect($user->role)->toBe('user');
    expect($user->phone)->toBe('081234567890');
    expect(Hash::check('Password123!', $user->password))->toBeTrue();
});

test('P2 - input tidak valid maka validasi gagal dan user tidak tersimpan', function () {
    $data = [
        'name'                  => '',           
        'email'                 => 'john@example.com',
        'password'              => 'Password123!',
        'password_confirmation' => 'Password123!',
        'phone'                 => '081234567890',
        'role'                  => 'user',
    ];

    $validator = Validator::make($data, unitValidationRules());

    if (!$validator->fails()) {
        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'],
            'role'     => $data['role'],
        ]);
    }

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('name'))->toBeTrue();
    expect(User::count())->toBe(0);
});