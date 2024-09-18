<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineSparePart extends Model
{
    use HasFactory;

    protected $table = 'machine_spare_parts';

    protected $fillable = [
        'machine_serial_number',
        'spare_part_serial_number',
    ];

    public $timestamps = false;

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_serial_number', 'serial_number');
    }

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class, 'spare_part_serial_number', 'serial_number');
    }
}
