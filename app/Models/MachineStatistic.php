<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineStatistic extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'machine_name',
        'operational_hours',
        'MTTR',
        'MTTD',
        'MTBF',
        'upTime',
        'downTime',
        'efficiency',
        'availability',
        'date'
    ];
}
