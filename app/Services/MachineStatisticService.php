<?php

namespace App\Services;

use App\Models\Machine;
use App\Models\MachineStatistic;
use Illuminate\Support\Facades\DB;

class MachineStatisticService
{
    public function calculateAndStoreStatistics($machineId, $date)
    {
        $machineInputs = DB::table('machine_inputs')
            ->where('machine_id', $machineId)
            ->whereDate('created_at', $date)
            ->get();

        if ($machineInputs->isEmpty()) {
            return;
        }

        $totalOperatingTime = $machineInputs->sum('operating_time');
        $totalDownTime = $machineInputs->sum('down_time');
        $totalFailures = $machineInputs->sum('number_of_failure');
        $totalOutput = $machineInputs->sum('actual_output');
        $unitPerHour = DB::table('machines')->where('id', $machineId)->value('unit_per_hour');
        $mtbr = $machineInputs->pluck('mtbr')->first(); 
        $theoreticalOutput=$unitPerHour;
        $MTTR = $totalFailures ? $totalDownTime / $totalFailures : null;
        $MTBF = $totalFailures ? $totalOperatingTime / $totalFailures : null;
        $availability = ($MTBF && ($MTBF + $mtbr)) ? $MTBF / ($MTBF + $mtbr) : null;
        $upTime = ($availability && $totalOperatingTime) ? $totalOperatingTime * $availability : null;
        $efficiency = ($theoreticalOutput && $totalOutput) ? ($totalOutput / $theoreticalOutput) * 100 : null;

        MachineStatistic::create([
            'machine_id' => $machineId,
            'date' => $date,
            'MTTR' => $MTTR,
            'MTBF' => $MTBF,
            'availability' => $availability,
            'upTime' => $upTime,
            'efficiency' => $efficiency,
        ]);
    }
}
