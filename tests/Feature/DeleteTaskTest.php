<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
{
    public function test_invalid_token()
    {
        $response = $this->deleteJson('/api/tasks/1');
        $response->assertStatus(401)->assertJsonStructure(['status', 'message']);
    }

    public function test_task_do_not_exist()
    {
        $user = $this->createUser();


        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->deleteJson('/api/tasks/1');

        $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
    }

    public function test_unauthorized_delete_task()
    {
        $user = $this->createUser();
        $user2 = $this->createUser();


        $this->createTask($user2['data']->id, 3);

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->deleteJson('/api/tasks/1');

        $response->assertStatus(403)->assertJsonStructure(['status', 'message']);
    }

    public function test_delete_task_with_success()
    {
        $user = $this->createUser();

        $this->createTask($user['data']->id, 3);


        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->deleteJson('/api/tasks/1');

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
