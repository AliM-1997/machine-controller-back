<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Machine;
use App\Models\Task;
use App\Models\User;
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
        $validatedData = $request->validated();
        $task = Task::create($validatedData);
        $user = User::find($task->user_id);
    
        if ($user) {
            Notification::send($user, new TaskNotification($task));
        }
        return response()->json([
            'success' => true,
            'message' => 'Task created successfully and user notified',
            'task' => $task
        ], 201);
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
            // if ($user) {
            //     Notification::send($user, new TaskNotification($task));
            // }
            if ($user) {
                $user->notify(new TaskNotification($task));
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

    public function getTaskByMachineName($name)
    {
        $machine = Machine::where('name', $name)->first();
    
        if (!$machine) {
            return response()->json(["message" => "Machine not found."], 404);
        }
            $tasks = Task::where('machine_id', $machine->id)->get();
    
        if ($tasks->isEmpty()) {
            return response()->json(["message" => "No tasks found for the given machine.",], 404);
        }
    
        return response()->json(['tasks' => $tasks], 200);
    }
    public function getTaskByStatus($status)
    {
        $status = trim($status);
            $tasks = Task::where('status', $status)->get();
            if ($tasks->isEmpty()) {
            return response()->json(["message" => "No Task Found for the given status"]);
        }
            return response()->json(["tasks" => $tasks]);
    }
    public function getTaskByDate($date)
    {
        $tasks=Task::where('dueDate',$date)->get();
        if ($tasks->isEmpty()) {
            return response()->json(["message" => "No tasks found for the given date.",], 404);
        }
    
        return response()->json(['tasks' => $tasks], 200);
    }

    public function getTaskByEmployee($username)
    {
        $user=User::where('username',$username)->first();
        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }
        $tasks=Task::where('user_id',$user->id)->get();
        if ($tasks->isEmpty()) {
            return response()->json(["message" => "No tasks found for the given date.",], 404);
        }
    
        return response()->json(['tasks' => $tasks], 200);
    }

}
