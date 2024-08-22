<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
