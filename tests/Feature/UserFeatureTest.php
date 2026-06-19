<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function actingAsAdmin()
{
    $admin = User::factory()->create(['role' => 'admin']);
    return test()->actingAs($admin);
}

function validUserData(array $overrides = []): array
{
    return array_merge([
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'Password123!',
        'password_confirmation' => 'Password123!',
        'phone'                 => '081234567890',
        'role'                  => 'user',
    ], $overrides);
}

test('EP-01 name valid maka user berhasil dibuat', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['name' => 'John Doe']))
        ->assertRedirect(route('users.index'))
        ->assertSessionHas('success', 'Tambah User berhasil!');

    expect(User::where('email', 'john@example.com')->exists())->toBeTrue();
});

test('EP-02 name lebih dari 255 karakter maka validasi error', function () {
    $nameTerlaluPanjang = str_repeat('a', 256);

    actingAsAdmin()
        ->post(route('users.store'), validUserData(['name' => $nameTerlaluPanjang]))
        ->assertSessionHasErrors(['name']);

    expect(User::count())->toBe(1);
});

test('EP-03 name kosong maka validasi error required', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['name' => '']))
        ->assertSessionHasErrors(['name']);

    expect(User::count())->toBe(1);
});

test('EP-04 email valid lowercase maka user berhasil dibuat', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['email' => 'john@example.com']))
        ->assertRedirect(route('users.index'))
        ->assertSessionHas('success', 'Tambah User berhasil!');
});

test('EP-05 format email tidak valid maka validasi error', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['email' => 'johnexamplecom']))
        ->assertSessionHasErrors(['email']);
});

test('EP-06 email sudah terdaftar maka validasi error unique', function () {
    User::factory()->create(['email' => 'john@example.com']);

    actingAsAdmin()
        ->post(route('users.store'), validUserData(['email' => 'john@example.com']))
        ->assertSessionHasErrors(['email']);
});

test('EP-07 email uppercase maka validasi error lowercase', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['email' => 'JOHN@EXAMPLE.COM']))
        ->assertSessionHasErrors(['email']);
});

test('EP-08 email lebih dari 255 karakter maka validasi error', function () {
    $emailPanjang = str_repeat('a', 250) . '@example.com';

    actingAsAdmin()
        ->post(route('users.store'), validUserData(['email' => $emailPanjang]))
        ->assertSessionHasErrors(['email']);
});

test('EP-09 password valid dan confirmed maka user berhasil dibuat', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData([
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]))
        ->assertRedirect(route('users.index'))
        ->assertSessionHas('success');
});

test('EP-10 password confirmation tidak cocok maka validasi error confirmed', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData([
            'password'              => 'Password123!',
            'password_confirmation' => 'BedaBanget999!',
        ]))
        ->assertSessionHasErrors(['password']);
});

test('EP-11 password kosong maka validasi error required', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData([
            'password'              => '',
            'password_confirmation' => '',
        ]))
        ->assertSessionHasErrors(['password']);
});


test('EP-12 phone valid maka user berhasil dibuat', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['phone' => '081234567890']))
        ->assertRedirect(route('users.index'))
        ->assertSessionHas('success');
});

test('EP-13 phone lebih dari 20 karakter maka validasi error max', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['phone' => '081234567890901234324']))
        ->assertSessionHasErrors(['phone']);
});

test('EP-14 phone kosong maka validasi error required', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['phone' => '']))
        ->assertSessionHasErrors(['phone']);
});

test('EP-15 role user valid maka user berhasil dibuat', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['role' => 'user']))
        ->assertRedirect(route('users.index'))
        ->assertSessionHas('success');

    expect(User::where('role', 'user')->where('email', 'john@example.com')->exists())->toBeTrue();
});

test('EP-16 role organizer valid maka user berhasil dibuat', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['role' => 'organizer']))
        ->assertRedirect(route('users.index'))
        ->assertSessionHas('success');

    expect(User::where('role', 'organizer')->exists())->toBeTrue();
});

test('EP-17 role admin tidak valid maka validasi error in', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['role' => 'admin']))
        ->assertSessionHasErrors(['role']);
});

test('EP-18 role kosong maka validasi error required', function () {
    actingAsAdmin()
        ->post(route('users.store'), validUserData(['role' => '']))
        ->assertSessionHasErrors(['role']);
});

test('ST-01 transisi state dari tidak ada user menjadi user tersimpan', function () {
    $jumlahAwal = User::where('role', '!=', 'admin')->count();
    expect($jumlahAwal)->toBe(0);

    actingAsAdmin()
        ->post(route('users.store'), validUserData());

    $jumlahAkhir = User::where('role', '!=', 'admin')->count();
    expect($jumlahAkhir)->toBe(1);
});

test('ST-02 transisi state validasi gagal sistem kembali ke form dengan error', function () {
    $response = actingAsAdmin()
        ->post(route('users.store'), validUserData(['email' => 'bukan-email']));

    $response->assertSessionHasErrors(['email']);

    expect(User::where('email', 'bukan-email')->exists())->toBeFalse();
});

test('ST-03 transisi menambah user kedua berhasil tanpa mengganggu user pertama', function () {
    User::factory()->create(['email' => 'first@example.com']);

    actingAsAdmin()
        ->post(route('users.store'), validUserData(['email' => 'second@example.com']))
        ->assertRedirect(route('users.index'));

    expect(User::whereIn('email', ['first@example.com', 'second@example.com'])->count())->toBe(2);
});

test('ST-04 transisi gagal karena email duplikat sistem tidak menambah user baru', function () {
    $request = actingAsAdmin();

    User::factory()->create(['email' => 'john@example.com']);

    $jumlahSebelum = User::count();

    $request
        ->post(route('users.store'), validUserData(['email' => 'john@example.com']))
        ->assertSessionHasErrors(['email']);

    expect(User::count())->toBe($jumlahSebelum);
});
