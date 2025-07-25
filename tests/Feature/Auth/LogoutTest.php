<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class, TestCase::class);

test('logged in user can logout', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $token = $response->json('token');
    $response = $this->postJson('/api/logout', [], [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'User logged out successfully',
    ]);

    $response = $this->getJson('/api/profile', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(401);
});
