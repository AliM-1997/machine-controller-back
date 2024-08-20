<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=[
        "user_id",
        "machine_id",
        "sparePart_id",
        "jobDescription",
        "assignedDate",
        "dueDate",
        "location"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
    public function sparePart()
    {
        return $this->belongsTo(Spare_Part::class);
    }
}
