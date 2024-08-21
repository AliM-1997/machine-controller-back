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
        'downtime',
        'number_of_failures',
        'actual_output'
    ];
}
