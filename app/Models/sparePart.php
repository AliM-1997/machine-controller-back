<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'serial_number',
        'quantity',
        'description',
        'image_path',
        'type',
        'standard_pressure',
        'life_cycle',
    ];
    public function task()
    {
        return $this->hasMany(Task::class);
    }
    public function machineSpareParts()
    {
        return $this->hasMany(MachineSparePart::class, 'spare_part_serial_number', 'serial_number');
    }
}
