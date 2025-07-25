<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class, TestCase::class);

test('user can register', function () {
    /** @var TestCase $this */
    $response = $this->postJson('/api/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret12',
        'password_confirmation' => 'secret12',
    ]);

    $response->assertStatus(201);
    $response->assertJson([
        'message' => 'User registered successfully',
    ]);
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
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
