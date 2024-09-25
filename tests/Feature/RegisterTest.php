<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Ali Mortada',
            'email' => 'AliMortada@test.com',
            'password' => 'ali123@',
        ]);

        $response->dump();

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'status',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                    'authorisation' => [
                        'token',
                        'type'
                    ]
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'AliMortada@test.com',
        ]);
    }
}
