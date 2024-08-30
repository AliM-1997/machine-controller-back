<?php

namespace App\Services;

use App\Models\MachineStatistic;

class MachineStatisticService
{
    
    // Define methods here
    public function calculateStatistics()
    {
        dd("hello");
        $d = "mk";
        $this->createstats($d);
    }

    public function createstats($value)
    {
        $stats = new MachineStatistic();
        $stats->MTTR = $value;
        $stats->save();
    }
}