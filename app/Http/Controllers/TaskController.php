<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderByCompleted = $request->query('completed');
        if (isset($orderByCompleted)) {
            $tasks = $request->user()->task()->where('completed', '=', true)->orderBy('created_at', 'desc')->get();
        } else {
            $tasks = $request->user()->task()->orderBy('created_at', 'desc')->get();
        }

        return response()->json(['status' => 'done', 'tasks' => $tasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $task = Task::create([
            'body' => $request->body,
            'user_id' => $request->user()->id,
            'completed' => true,
        ]);

        return response()->json(['status' => 'done', 'task' => $task], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['status' => 'error', 'message' => 'Element not found'], 404);
        }

        if ($task->user_id !== auth()->user()->id) {
            return response()->json([
                "status" => "error",
                "message" => "You do not have permission to access this content"
            ], 403);
        }


        return response()->json(['status' => 'done', 'task' => $task], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['status' => 'error', 'message' => 'Element not found'], 404);
        }

        if ($task->user_id !== auth()->user()->id) {
            return response()->json([
                "status" => "error",
                "message" => "You do not have permission to access this content"
            ], 403);
        }

        $request->validate([
            'body' => 'string',
            'completed' => 'boolean',
        ]);

        if ($request->has('body')) {
            $task->body = $request->body;
        }
        if ($request->has('completed')) {
            $task->completed = $request->completed;
        }

        $task->save();

        return response()->json(['status' => 'done', 'task' => $task], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['status' => 'error', 'message' => 'Element not found'], 404);
        }

        if ($task->user_id !== auth()->user()->id) {
            return response()->json([
                "status" => "error",
                "message" => "You do not have permission to access this content"
            ], 403);
        }

        $task->delete();

        return response()->json(['status' => 'done', 'task' => $task], 200);
    }
}
