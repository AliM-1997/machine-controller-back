<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\SparePart;
use App\Models\MachineSparePart;

class MachineSparePartController extends Controller
{

    public function create(Request $request)
{
    // Validate the request
    $request->validate([
        'machine_serial_number' => 'required|string',
        'spare_part_serial_number' => 'required|string',
    ]);

    $machine = Machine::where('serial_number', $request->input('machine_serial_number'))->first();
    $sparePart = SparePart::where('serial_number', $request->input('spare_part_serial_number'))->first();


    if (!$machine) {
        return response()->json(['error' => 'Machine not found'], 404);
    }

    if (!$sparePart) {
        return response()->json(['error' => 'Spare part not found'], 404);
    }

    $existingRelation = MachineSparePart::where('machine_serial_number', $request->input('machine_serial_number'))
        ->where('spare_part_serial_number', $request->input('spare_part_serial_number'))
        ->first();

    if ($existingRelation) {
        return response()->json(['message' => 'Relationship already exists'], 200);
    }

    $machineSparePart = MachineSparePart::create([
        'machine_serial_number' => $request->input('machine_serial_number'),
        'spare_part_serial_number' => $request->input('spare_part_serial_number'),
    ]);

    return response()->json(['message' => 'Spare part attached to machine successfully'], 201);
}
public function getRelationship(Request $request)
{
    $request->validate([
        'machine_serial_number' => 'required|string',
        'spare_part_serial_number' => 'required|string',
    ]);

    $relationship = MachineSparePart::where('machine_serial_number', $request->input('machine_serial_number'))
        ->where('spare_part_serial_number', $request->input('spare_part_serial_number'))
        ->first();

    if (!$relationship) {
        return response()->json(['error' => 'Relationship not found'], 404);
    }
    $sparePart = SparePart::where('serial_number', $request->input('spare_part_serial_number'))->first();

    return response()->json([
        'relationship' => $relationship,
        'spare_part' => $sparePart
    ], 200);
}
public function getSparePartsByMachine(Request $request)
{
    $request->validate([
        'machine_serial_number' => 'required|string',
    ]);

    // Find the machine based on the serial number
    $machine = Machine::where('serial_number', $request->input('machine_serial_number'))->first();

    if (!$machine) {
        return response()->json(['error' => 'Machine not found'], 404);
    }

    // Get all spare parts associated with the machine
    $sparePartsRelations = MachineSparePart::where('machine_serial_number', $request->input('machine_serial_number'))->get();

    // Retrieve detailed information for each spare part
    $spareParts = $sparePartsRelations->map(function ($relation) {
        return SparePart::where('serial_number', $relation->spare_part_serial_number)->first();
    })->filter(); // Remove any null results if spare parts are not found

    return response()->json([
        'machine' => $machine,
        'spare_parts' => $spareParts
    ], 200);
}

}