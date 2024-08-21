<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachineRequest;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machine=Machine::all();
        return response()->json([
            "machineInputs"=>$machine
        ]);
    }
    public function show(Machine $machine)
    {
        return response()->json(['machine_input' => $machine]);
    }
    public function destroy(Machine $machine)
    {
        $machine->delete();
        return response()->json("null",204);
    }
    public function store(StoreMachineRequest $request)
    {
        $validate=$request->validated();
        $machine=Machine::create($validate);
        return response()->json([
            "machineInput"=>$machine
        ],201);
    }
    

}
