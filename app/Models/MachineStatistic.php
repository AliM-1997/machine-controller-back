<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineStatistic extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'machine_id',
        'MTTR',
        'MTBF',
        // 'MTTD',
        'upTime',
        'efficiency',
        'availability',
        'date'
    ];
    public function machine()
    {
       return $this->belongsTo(Machine::class);
    }
}
