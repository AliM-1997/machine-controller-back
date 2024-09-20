<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachineInputRequest;
use App\Http\Requests\UpdateMachineInputRequest;
use App\Models\Machine;
use Illuminate\Http\Request;
use App\Models\MachineInput;

class MachineInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machineInputs=MachineInput::all();
        return response()->json([
            "machineInputs"=>$machineInputs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreMachineInputRequest $request)
    {
        $validated = $request->validated();

        $machine = Machine::where('serial_number', $validated['serial_number'])->first();

        if (!$machine) {
            return response()->json(['error' => 'Machine with given serial number not found.'], 404);
        }

        $machineInput = MachineInput::create([
            'machine_id' => $machine->id, 
            'operating_time' => $validated['operating_time'],
            'down_time' => $validated['down_time'],
            'number_of_failure' => $validated['number_of_failure'],
            'actual_output' => $validated['actual_output'],
        ]);

        return response()->json([
            'machineInput' => $machineInput
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MachineInput $machineInput)
    {
        return response()->json(['machine_input' => $machineInput]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMachineInputRequest $request, MachineInput $machineInput)
    {
        $machineInput->update($request->validated());
        return response()->json([
            "machineInput"=>$machineInput
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MachineInput $machineInput)
    {
        $machineInput->delete();
        return response()->json("null",204);
    }
}
