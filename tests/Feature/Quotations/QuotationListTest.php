<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\User;
use Database\Seeders\AgeLoadSeeder;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class, TestCase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->seed(AgeLoadSeeder::class);
    $this->seed(CurrencySeeder::class);
});

test('user can list their quotations', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();
    $token = JWTAuth::fromUser($user);
    $currency = Currency::where('code', 'EUR')->first();

    $user->quotations()->create([
        'currency_id' => $currency->id,
        'age' => '28,35',
        'total' => 117.00,
        'start_date' => '2020-10-01',
        'end_date' => '2020-10-30',
    ]);
    $user->quotations()->create([
        'currency_id' => $currency->id,
        'age' => '40',
        'total' => 60.00,
        'start_date' => '2021-01-01',
        'end_date' => '2021-01-10',
    ]);

    $response = $this->getJson('/api/quotations', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJsonCount(2);
    $response->assertJsonFragment([
        'currency_id' => 'EUR',
        'age' => '28,35',
        'total' => '117.00',
        'start_date' => '2020-10-01',
        'end_date' => '2020-10-30',
    ]);
    $response->assertJsonFragment([
        'currency_id' => 'EUR',
        'age' => '40',
        'total' => '60.00',
        'start_date' => '2021-01-01',
        'end_date' => '2021-01-10',
    ]);
});
