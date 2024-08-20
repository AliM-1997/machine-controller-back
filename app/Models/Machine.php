<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'serial_number',
        'status',
        'location',
        'image_path',
        'description',
        'unit_per_hour'    
    ];
    public function task()
    {
        return $this->hasMany(Task::class); 
    }
    public function statistic()
    {
        return $this->hasMany(MachineStatistic::class);
    }
}

