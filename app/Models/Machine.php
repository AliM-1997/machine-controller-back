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
        'last_maintenance',
        'unit_per_hour',

    ];
    public function task()
    {
        return $this->hasMany(Task::class); 
    }
    public function statistic()
    {
        return $this->hasMany(MachineStatistic::class);
    }
    public function input()
    {
        return $this->hasMany(MachineInput::class);
    }
    public function spareParts()
    {
        return $this->hasMany(MachineSparePart::class, 'machine_serial_number', 'serial_number');
    }

}

