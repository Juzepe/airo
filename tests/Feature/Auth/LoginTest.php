<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(RefreshDatabase::class, TestCase::class);

test('registered user can login', function () {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'User logged in successfully',
    ]);

    $token = $response->json('token');
    $response = $this->getJson('/api/profile', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'user' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ],
    ]);
});
