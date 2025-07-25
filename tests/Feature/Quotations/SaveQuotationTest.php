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

test('user can calculate quotation', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();
    $token = JWTAuth::fromUser($user);

    $response = $this->postJson('/api/quotations', [
        'age' => '28,35',
        'currency_id' => 'EUR',
        'start_date' => '2020-10-01',
        'end_date' => '2020-10-30',
    ], [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'quotation_id',
        'total',
        'currency_id',
    ]);
    $response->assertJson([
        'total' => 117.00,
        'currency_id' => 'EUR',
    ]);

    $currency = Currency::where('code', 'EUR')->first();
    $this->assertDatabaseHas('quotations', [
        'user_id' => $user->id,
        'currency_id' => $currency->id,
        'total' => 117.00,
    ]);
});

test('user cannot calculate quotation if proper age load is not found', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();
    $token = JWTAuth::fromUser($user);

    $response = $this->postJson('/api/quotations', [
        'age' => '28,15,35',
        'currency_id' => 'EUR',
        'start_date' => '2020-10-01',
        'end_date' => '2020-10-30',
    ], [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(422);
    $response->assertJson([
        'message' => 'One of the ages is not valid.',
        'errors' => [
            'age' => ['One of the ages is not valid.'],
        ],
    ]);
});

test('quotation dates must be in ISO 8601 format', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();
    $token = JWTAuth::fromUser($user);

    $response = $this->postJson('/api/quotations', [
        'age' => '28,35',
        'currency_id' => 'EUR',
        'start_date' => '2020/10/01',
        'end_date' => '2020/10/30',
    ], [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(422);
    $response->assertJson([
        'message' => 'The start date must be a valid date in ISO 8601 format (YYYY-MM-DD). (and 1 more error)',
        'errors' => [
            'start_date' => ['The start date must be a valid date in ISO 8601 format (YYYY-MM-DD).'],
            'end_date' => ['The end date must be a valid date in ISO 8601 format (YYYY-MM-DD).'],
        ],
    ]);
});
