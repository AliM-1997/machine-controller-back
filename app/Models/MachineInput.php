<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineInput extends Model
{
    use HasFactory;
    protected $fillable=[
        'machine_id',
        'operating_time',
        'down_time',
        'number_of_failure',
        'actual_output'
    ];
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
