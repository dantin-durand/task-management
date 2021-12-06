<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GetAllTasksTest extends TestCase
{
    public function test_invalid_token()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401)->assertJsonStructure(['status', 'message']);
    }

    public function test_get_all_tasks()
    {
        $user = $this->createUser();

        $this->createTask($user['data']['id'], 3);

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'tasks' => [
                    [
                        'id',
                        'user_id',
                        'body',
                        'created_at',
                        'updated_at',
                        'completed',
                    ]
                ]
            ]);
    }

    public function test_get_all_tasks_by_completed()
    {
        $user = $this->createUser();

        $this->createTask($user['data']['id'], 3);

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->getJson('/api/tasks?completed=true');


        $contentResponse = json_decode($response->getContent(), true);

        foreach ($contentResponse['tasks'] as $task) {
            if ($task['completed'] != true) $this->fail('the task is not in "completed"');
        }
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'tasks' => [
                    [
                        'id',
                        'user_id',
                        'body',
                        'created_at',
                        'updated_at',
                        'completed',
                    ]
                ]
            ]);
    }

    public function test_get_all_tasks_order_by_created_at()
    {
        $user = $this->createUser();

        $this->createTask($user['data']['id'], 3, true);

        $response = $this->withHeader('Authorization', 'Bearer ' . $user['token'])
            ->getJson('/api/tasks');

        $contentResponse = json_decode($response->getContent(), true);
        $sortTasks = collect($contentResponse['tasks'])->sortByDesc('created_at')->all();

        if (array_shift($sortTasks)['id'] !== array_shift($contentResponse['tasks'])['id']) $this->fail('the tasks are not sorted by created_at');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'tasks' => [
                    [
                        'id',
                        'user_id',
                        'body',
                        'created_at',
                        'updated_at',
                        'completed',
                    ]
                ]
            ]);
    }
}
