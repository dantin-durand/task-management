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

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password'])
        ]);

        $token = auth()->attempt([
            'email' => $userData['email'],
            'password' => $userData['password']
        ]);

        return ["token" => $token, "data" => $user];
    }

    public function test_invalid_token()
    {
        $response = $this->postJson('/api/logout');
        $response->assertStatus(401)->assertJsonStructure(['status', 'message']);
    }

    public function test_logout_with_success()
    {
        $user = $this->createUser();

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->postJson('/api/logout');

        $response->assertStatus(200)->assertJsonStructure(['status', 'message']);
    }
}
