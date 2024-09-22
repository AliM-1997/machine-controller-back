<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Machine;
use App\Models\SparePart;
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
        // event(new Notifications($user->name, "A new task has been assigned to you"));

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
    public function update(UpdateTaskRequest $request, $taskId)
{
    $validatedData = $request->validated();
    $task = Task::find($taskId);

    if (!$task) {
        return response()->json([
            'success' => false,
            'message' => 'Task not found',
        ], 404);
    }
    $user = User::where('username', $validatedData['username'])->first();
    $machine = Machine::where('serial_number', $validatedData['machine_serial_number'])->first();
    $sparePart = isset($validatedData['sparePart_serial_number'])
        ? SparePart::where('serial_number', $validatedData['sparePart_serial_number'])->first()
        : null;

    if (!$user || !$machine) {
        return response()->json([
            'success' => false,
            'message' => 'User or Machine not found',
        ], 404);
    }
    $task->user_id = $user->id;
    $task->machine_id = $machine->id;
    $task->spare_part_id = $sparePart ? $sparePart->id : null;
    $task->jobDescription = $validatedData['jobDescription'];
    $task->assignedDate = $validatedData['assignedDate'];
    $task->dueDate = $validatedData['dueDate'];
    $task->location = $validatedData['location'];
    $task->status = $validatedData['status'];

    $task->save();

    if ($user) {
        $user->notify(new TaskNotification($task));
    }

    return response()->json([
        'success' => true,
        'task' => $task
    ], 200);
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
    
public function getTaskByMachinSerialNumber($serialnumber)
{
    $machine = Machine::where('serial_number', $serialnumber)->first();

    if (!$machine) {
        return response()->json(["message" => "Machine not found."], 404);
    }

    $tasks = Task::with(['user', 'sparePart'])->where('machine_id', $machine->id)->get();

    if ($tasks->isEmpty()) {
        return response()->json(["message" => "No tasks found for the given machine."], 404);
    }

    $taskDetails = $tasks->map(function ($task) {
        return [
            'id' => $task->id,
            'username' => $task->user->username, 
            'machine_serial_number' => $task->machine->serial_number,
            'sparePart_serial_number' => $task->sparePart ? $task->sparePart->serial_number : null, 
            'jobDescription' => $task->jobDescription,
            'assignedDate' => $task->assignedDate,
            'dueDate' => $task->dueDate,
            'location' => $task->location,
            'status' => $task->status,
        ];
    });

    return response()->json(['tasks' => $taskDetails], 200);
}

public function getTaskByStatus($status)
{
    $status = trim($status);
    $tasks = Task::with(['user', 'machine', 'sparePart'])->where('status', $status)->get();

    if ($tasks->isEmpty()) {
        return response()->json(["message" => "No tasks found for the given status."], 404);
    }

    $taskDetails = $tasks->map(function ($task) {
        return [
            'id' => $task->id,
            'username' => $task->user->username,
            'machine_serial_number' => $task->machine->serial_number,
            'sparePart_serial_number' => $task->sparePart ? $task->sparePart->serial_number : null,
            'jobDescription' => $task->jobDescription,
            'assignedDate' => $task->assignedDate,
            'dueDate' => $task->dueDate,
            'location' => $task->location,
            'status' => $task->status,
        ];
    });

    return response()->json(['tasks' => $taskDetails], 200);
}

public function getTaskByDate($date)
{
    $tasks = Task::with(['user', 'machine', 'sparePart'])->where('dueDate', $date)->get();

    if ($tasks->isEmpty()) {
        return response()->json(["message" => "No tasks found for the given date."], 404);
    }

    $taskDetails = $tasks->map(function ($task) {
        return [
            'id' => $task->id,
            'username' => $task->user->username,
            'machine_serial_number' => $task->machine->serial_number,
            'sparePart_serial_number' => $task->sparePart ? $task->sparePart->serial_number : null,
            'jobDescription' => $task->jobDescription,
            'assignedDate' => $task->assignedDate,
            'dueDate' => $task->dueDate,
            'location' => $task->location,
            'status' => $task->status,
        ];
    });

    return response()->json(['tasks' => $taskDetails], 200);
}


    public function getTaskByEmployee($username)
    {
        // Fetch the user by username
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }
        
        $tasks = Task::with(['machine', 'sparePart'])->where('user_id', $user->id)->get();
    
        if ($tasks->isEmpty()) {
            return response()->json(["message" => "No tasks found for the given user."], 404);
        }
    
        $taskDetails = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'username' => $task->user->username,
                'machine_serial_number' => $task->machine->serial_number, 
                'sparePart_serial_number' => $task->sparePart ? $task->sparePart->serial_number : null, 
                'jobDescription' => $task->jobDescription,
                'assignedDate' => $task->assignedDate,
                'dueDate' => $task->dueDate,
                'location' => $task->location,
                'status' => $task->status,
            ];
        });
    
        return response()->json(['tasks' => $taskDetails], 200);
    }
    

    public function createTaskByUsername(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::where('username', $validatedData['username'])->first();
        $machine = Machine::where('serial_number', $validatedData['machine_serial_number'])->first();
        $sparePart = null;
        if (isset($validatedData['sparePart_serial_number'])) {
            $sparePart = SparePart::where('serial_number', $validatedData['sparePart_serial_number'])->first();   
        }
        unset($validatedData['username'], $validatedData['machine_serial_number'], $validatedData['sparePart_serial_number']);
        
        $validatedData['user_id'] = $user->id;
        $validatedData['machine_id'] = $machine->id;
        $validatedData['spare_Part_id'] = $sparePart ? $sparePart->id : null;
        
        $task = Task::create($validatedData);
        
        $user->notify(new TaskNotification($task));
        
        return response()->json([
            'success' => true,
            'message' => 'Task created successfully and user notified',
            'task' => $task
        ], 201);
    }
    public function getTaskWithDetails($taskId)
    {
        $task = Task::with(['user', 'machine', 'sparePart'])->find($taskId);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'task' => [
                'id' => $task->id,
                'username' => $task->user->username,
                'machine_serial_number' => $task->machine->serial_number,
                'sparePart_serial_number' => $task->sparePart ? $task->sparePart->serial_number : null,
                'jobDescription' => $task->jobDescription,
                'assignedDate' => $task->assignedDate,
                'dueDate' => $task->dueDate,
                'location' => $task->location,
                'status' => $task->status,
            ]
        ], 200);
    }

    public function getAllTasksWithDetails()
{
    $tasks = Task::with(['user', 'machine'])->get();

    $formattedTasks = $tasks->map(function ($task) {
        return [
            'id' => $task->id,
            'username' => $task->user->username,
            'machine_serial_number' => $task->machine->serial_number,
            'sparePart_serial_number' => $task->sparePart ? $task->sparePart->serial_number : null,
            'jobDescription' => $task->jobDescription,
            'assignedDate' => $task->assignedDate,
            'dueDate' => $task->dueDate,
            'location' => $task->location,
            'status' => $task->status,
        ];
    });

    return response()->json([
        'success' => true,
        'tasks' => $formattedTasks
    ], 200);
}
public function addTaskReport(Request $request, $taskId)
{
    $request->validate([
        'user_report' => 'required|string',
    ]);

    
    $task = Task::find($taskId);

    if (!$task) {
        return response()->json(['message' => 'Task not found.'], 404);
    }

    $task->user_report = $request->input('user_report');
    $task->status = 'Completed'; 

    $task->save();

    return response()->json(['message' => 'Task report added and status updated to done.', 'task' => $task], 200);
}


}

