<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{

    public function test_invalid_token()
    {
        $task = [
            'body' => $this->faker->sentence($nbWords = 20, $variableNbWords = true)
        ];
        $response = $this->postJson('/api/tasks', $task);
        $response->assertStatus(401)->assertJsonStructure([
            "status",
            "message"
        ]);
    }

    public function test_empty_input()
    {
        $user = $this->createUser();

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->postJson('/api/tasks');
        $response->assertStatus(422)->assertJsonStructure(['message', 'errors']);
    }

    public function test_invalid_input()
    {
        $user = $this->createUser();

        $task = [
            'body' => true,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->postJson('/api/tasks');

        $response->assertStatus(422)->assertJsonStructure(['message', 'errors']);
    }

    public function test_create_task()
    {
        $user = $this->createUser();

        $task = [
            'body' => $this->faker->sentence($nbWords = 20, $variableNbWords = true)
        ];
        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->postJson('/api/tasks', $task);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'task' => [
                    "id",
                    "user_id",
                    "body",
                    "created_at",
                    "updated_at",
                    "completed"
                ]
            ]);
    }
}
