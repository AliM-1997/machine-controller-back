<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machine=Machine::all();
        return response()->json([
            "machineInputs"=>$machine
        ]);
    }
}
