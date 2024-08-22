<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachineStatisticRequest;
use App\Models\MachineStatistic;
use Illuminate\Http\Request;

class MachineStatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistic=MachineStatistic::all();
        return response()->json([
            "statistic"=>$statistic
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMachineStatisticRequest $request)
    {
        $validation=$request->validated();

        $validation=MachineStatistic::create($validation);
        return response()->json([
            'machine statistics'=>$validation
        ],201);
     }
    

    /**
     * Display the specified resource.
     */
    public function show(MachineStatistic $machineStatistic)
    {
        return response()->json(['machine'=>$machineStatistic]);
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
    public function destroy(MachineStatistic $machineStatistic)
    {
        $machineStatistic->delete();
        return response()->json([null,204]);
    }
}
