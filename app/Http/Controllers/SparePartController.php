<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSparePartRequest;
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
}
