<?php

namespace App\Http\Controllers;

use App\Http\Requests\getStaticByDateRequest;
use App\Http\Requests\StoreMachineStatisticRequest;
use App\Http\Requests\UpdateMachineStatisticRequest;
use App\Models\Machine;
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
    public function update(UpdateMachineStatisticRequest $request, MachineStatistic $machineStatistic)
    {
        $machineStatistic->update($request->validated());
        return response()->json([
            'machine statistic'=>$machineStatistic
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MachineStatistic $machineStatistic)
    {
        $machineStatistic->delete();
        return response()->json([null,204]);
    }
    public function getStatisticByMachineId($machineId)
    {
        $machine = Machine::with('statistic')->find($machineId);
        if (!$machine) {
            return response()->json([
                'error' => 'Machine not found'
            ], 404);
        }
            return response()->json([
            'machine' => $machine->name,
            'statistics' => $machine->statistic
        ]);
    }
    public function getStatisticsForMachinesComparison(Request $request)
{
    $validated = $request->validate([
        'machine_id_1' => 'required|exists:machines,id',
        'machine_id_2' => 'required|exists:machines,id'
    ]);

    $machine1 = Machine::with('statistic')->find($validated['machine_id_1']);
    $machine2 = Machine::with('statistic')->find($validated['machine_id_2']);

    return response()->json([
        'machine_1' => $machine1 ? [
            'name' => $machine1->name,
            'statistics' => $machine1->statistic
        ] : null,
        'machine_2' => $machine2 ? [
            'name' => $machine2->name,
            'statistics' => $machine2->statistic
        ] : null
    ]);
}

    public function getStatisticByDate(getStaticByDateRequest $request)
    {
        $validated = $request->validated();
        $query = MachineStatistic::query();

        if (isset($validated['date']))
            {
                $query->whereDate('date', $validated['date']);
            } 
        elseif (isset($validated['startDate']) && isset($validated['endDate'])) 
            {
                $startDate = $validated['startDate'];
                $endDate = $validated['endDate'];
                $query->whereBetween('date', [$startDate, $endDate]);
            }
        $statistics = $query->get();
        return response()->json([
            'statistics' => $statistics
            ]);
    }
}