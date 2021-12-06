<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogoutTest extends TestCase
{

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
