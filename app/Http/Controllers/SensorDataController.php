<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        if ($request->isJson()) {
            $data = $request->json()->all();


            if (isset($data['Temperature'])) {
                $sensorData = new SensorData();
                $sensorData->Temperature = $data['Temperature'];
                $sensorData->save();

                return response()->json(['message' => 'Data received successfully'], 200)
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'POST')
                    ->header('Access-Control-Allow-Headers', 'Content-Type');
            } else {
                return response()->json(['error' => 'Invalid data received', 'received_data' => $data], 400);
            }
        } else {
            return response()->json(['error' => 'Invalid data format'], 400);
        }
    }
}
