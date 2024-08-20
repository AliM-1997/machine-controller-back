<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=[
        "user_id",
        "machine_name",
        "sparePart_serial_number",
        "jobDescription",
        "assignedDate",
        "dueDate",
        "location"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
