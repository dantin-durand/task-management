<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EditTaskTest extends TestCase
{
    public function test_invalid_token()
    {
        $task = [
            'body' => $this->faker->sentence($nbWords = 20, $variableNbWords = true),
        ];

        $response = $this->putJson('/api/tasks/1', $task);
        $response->assertStatus(401)->assertJsonStructure(['status', 'message']);
    }

    public function test_task_do_not_exist()
    {
        $user = $this->createUser();

        $task = [
            'body' => $this->faker->sentence($nbWords = 20, $variableNbWords = true),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->putJson('/api/tasks/1', $task);

        $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
    }

    public function test_unauthorized_edit_task()
    {
        $user = $this->createUser();
        $user2 = $this->createUser();

        $this->createTask($user2['data']->id, 3);

        $task = [
            'body' => $this->faker->sentence($nbWords = 20, $variableNbWords = true),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->putJson('/api/tasks/1', $task);

        $response->assertStatus(403)->assertJsonStructure(['status', 'message']);
    }

    public function test_empty_inputs()
    {
        $user = $this->createUser();

        $this->createTask($user['data']->id, 1);

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->putJson('/api/tasks/1');

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'task' => [
                'id',
                'body',
                'user_id',
                'created_at',
                'updated_at',
                'completed',
            ]
        ]);
    }

    public function test_invalid_input()
    {
        $user = $this->createUser();

        $this->createTask($user['data']->id, 1);

        $task = [
            'body' => true,
            'completed' => 'false'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->putJson('/api/tasks/1', $task);

        $response->assertStatus(422)->assertJsonStructure(['message', 'errors']);
    }

    public function test_edit_task_with_success()
    {
        $user = $this->createUser();

        $this->createTask($user['data']->id, 3);

        $task = [
            'body' => $this->faker->sentence($nbWords = 20, $variableNbWords = true),
            'completed' => false
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->putJson('/api/tasks/1', $task);

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'task' => [
                'id',
                'body',
                'user_id',
                'created_at',
                'updated_at',
                'completed',
            ]
        ]);
    }
}
