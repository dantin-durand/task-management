<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogoutTest extends TestCase
{

    public function createUser()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password(8)
        ];

        return ["userData" => $userData, "userCreate" => User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password'])
        ])];
    }
    public function test_invalid_token()
    {
        $response = $this->postJson('/api/logout');
        $response->assertStatus(401)->assertJsonStructure(['status', 'message']);
    }
    public function test_logout_with_success()
    {
        $user = $this->createUser();

        $token = auth()->attempt([
            'email' => $user['userData']['email'],
            'password' => $user['userData']['password']
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertStatus(200)->assertJsonStructure(['status', 'message']);
    }
}
