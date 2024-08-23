<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Notifications\TaskNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use function PHPUnit\Framework\returnSelf;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task=Task::all();
        return response()->json(['task'=>$task]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validation=$request->validated();
        $task=Task::create($validation);
        $user = $task->user;
        if ($user) {
            Notification::send($user, new TaskNotification($task));
    }
        return response()->json([
            'task'=>$task
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json(['task'=>$task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
            $user = $task->user;
            if ($user) {
                Notification::send($user, new TaskNotification($task));
            }
        return response()->json([
            'task'=>$task
        ],200);      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null,204);
    }
}
