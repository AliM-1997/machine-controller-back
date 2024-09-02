<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachineRequest;
use App\Http\Requests\UpdateMachineRequest;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MachineController extends Controller
{
    public function getSerialNumbers()
    {
        $serialNumbers = Machine::pluck("serial_number");
        $formattedSerialNumbers = $serialNumbers->map(function ($serialNumber) {
            return ['label' => $serialNumber];
        });
                return response()->json($formattedSerialNumbers);
    }
    public function getAllName()
    {
        $name = Machine::pluck("name");
        $formattedname= $name->map(function ($name) {
            return ['label' => $name];
        });
                return response()->json($formattedname);
    }
    public function index()
    {   
        $machine=Machine::all();
        return response()->json([
            "machineInputs"=>$machine
        ]);
    }
    public function show(Machine $machine)
    {
        return response()->json(['machine_input' => $machine]);
    }
    public function destroy(Machine $machine)
    {
        $machine->delete();
        return response()->json("null",204);
    }
    public function store(StoreMachineRequest $request)
    {
        $validate=$request->validated();
        $machine=Machine::create($validate);
        return response()->json([
            "machineInput"=>$machine
        ],201);
    }
    public function update(UpdateMachineRequest $request,Machine $machine)
    {
        $machine->update($request->validated());
        return response()->json([
            "machine"=>$machine
        ],200);
    }
    public function updateMachineImage(Request $request, $machineId)
    {
        // Validate the image file
        $valifdator=Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($valifdator->fails()){
            return response()->json([
                'error'=>$valifdator->errors()
            ]);
        }
        // Find the machine by ID
        $machine = Machine::findOrFail($machineId);

        // Delete the old image if it exists
        if ($machine->image_path) {
            Storage::disk('public')->delete($machine->image_path);
        }

        // Handle the new image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('machine_images', $imageName, 'public');

        // Update the image path in the database
        $machine->image_path = $imagePath;
        $machine->save();

        return response()->json([
            'message' => 'Image updated successfully',
            'image_path' => $imagePath,
            'image_url' => Storage::url($imagePath),
        ], 200);
    }
    public function getMachineImage($machineId)
    {
        $machine = Machine::findOrFail($machineId);
        $imageUrl = $machine->image_path;
        return response()->json(['image_url' => $imageUrl]);
    }
    public function deleteMachineImage($machineId)
    {
        $machine = Machine::findOrFail($machineId);
        if ($machine->image_path) {{
                Storage::disk('public')->delete($machine->image_path);
            }
            $machine->image_path = null;
            $machine->save();
        }
        return response()->json(['message' => 'Image deleted successfully.']);
    }
    public function GetByMachineName($name)
    {
        $machine = Machine::where('name', $name)->first();
            if (!$machine) {
            return response()->json(['error' => 'Machine not found'], 404);
        }
        return response()->json([
            "machine" => $machine
        ], 200);
    }

}
