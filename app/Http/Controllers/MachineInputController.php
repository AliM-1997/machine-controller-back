<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachineInputRequest;
use App\Http\Requests\UpdateMachineInputRequest;
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
        $validate=$request->validated();
        $machineInput=MachineInput::create($validate);
        return response()->json([
            "machineInput"=>$machineInput
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MachineInput $machineInputs)
    {
        return response()->json_decode(["MachineInput"=>$machineInputs]);
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
