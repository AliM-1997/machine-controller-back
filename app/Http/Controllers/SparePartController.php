<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSparePartRequest;
use App\Http\Requests\UpdateSparePartRequest;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    public function show(SparePart $sparePart)
    {
        return response()->json(['spare_part' => $sparePart]);
    }
    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();
        return response()->json(null,204);
    }
    public function store(StoreSparePartRequest $requset)
    {
        $validate=$requset->validated();
        $sparePart=SparePart::create($validate);
        return response()->json([
            "sparePart"=>$sparePart
        ],201);
    }
    public function update(UpdateSparePartRequest $requset,SparePart $sparePart)
    {
        $sparePart->update($requset->validated());
        return response()->json([
            "spare_part"=>$sparePart
        ],200);
    }
    public function updateSparePartImage(Request $request, $sparePartId)
    {
        // Validate the image file
        $validator=Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()){
            return response()->json([
                'error'=>$validator->errors()
            ]);
        };
        // Find the user by ID
        $sparePart = SparePart::findOrFail($sparePartId);
    
        // Delete the old image if it exists
        if ($sparePart->image_path) {
                Storage::disk('public')->delete($sparePart->image_path);
        }
    
        // Handle the new image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('sparePart_image', $imageName, 'public');
    
        // Update the image path in the database
        $sparePart->image_path = $imagePath;
        $sparePart->save();
    
        return response()->json([
            'message' => 'Image updated successfully',
            'image_path' => $imagePath,
            'image_url' => Storage::url($imagePath),
        ], 200);
    }
}
