<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
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
