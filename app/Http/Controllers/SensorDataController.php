<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'humidity' => 'required|numeric',
            'air_temperature' => 'required|numeric',
            'process_temperature' => 'required|numeric',
            'rotational_speed' => 'required|numeric',
            'torque' => 'required|numeric',
            'operational_time' => 'required|numeric',
        ]);

        // Save data to the database
        SensorData::create($validatedData);

        return response()->json(['message' => 'Data received successfully'], 200);
    }
}
