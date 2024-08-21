<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sparePart=SparePart::all();
        return response()->json([
            "machineInputs"=>$sparePart
        ]);
    }
}
