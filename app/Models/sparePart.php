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
        'image_path'
    ];
    public function task()
    {
        return $this->hasMany(Task::class);
    }
}
