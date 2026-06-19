<?php

namespace Tests\Unit;

use Tests\TestCase;

uses(TestCase::class);


test('store event berhasil dengan semua field credential valid', function () {

    $data = [
        'title'          => 'FANMEETING Waras Group In Surabaya',
        'description'    => 'Deskripsi FANMEETING Waras Group',
        'location'       => 'Aula Telkom University Surabaya',
        'start_date'     => '2026-06-17',
        'end_date'       => '2026-06-19',
        'payment_method' => 'transfer',
        'account_number' => '123456789',
    ];

    $validator = validator($data, [
        'title'          => 'required',
        'description'    => 'required',
        'location'       => 'required',
        'start_date'     => 'required',
        'end_date'       => 'required',
        'payment_method' => 'required',
        'account_number' => 'required',
    ]);

    expect($validator->fails())->toBeFalse();
});

test('store event gagal jika title kosong', function () {
    $data = [
        'title'          => '',
        'description'    => 'Deskripsi FANMEETING Waras Group',
        'location'       => 'Aula Telkom University Surabaya',
        'start_date'     => '2026-06-17',
        'end_date'       => '2026-06-19',
        'payment_method' => 'transfer',
        'account_number' => '123456789',
    ];

    $validator = validator($data, [
        'title' => 'required',
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('title'))->toBeTrue();
});

test('store event gagal jika name tiket kosong', function () {
    $data = [
        'name'  => '',
        'price' => 850000,
        'quota' => 150,
    ];

    $validator = validator($data, [
        'name'  => 'required',
        'price' => 'required',
        'quota' => 'required',
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('name'))->toBeTrue();
});