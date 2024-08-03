<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{

    public function index()
    {
        $datos = Lot::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = new Lot();
        $datos->name = $request->name;
        $datos->description = $request->description;
        $datos->save();
        return response()->json(["message" => "success", "data" => $datos]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = Lot::find($id);
        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datos = Lot::find($id);
        if (!$datos) {
            return response()->json(["message" => "not found"], 404);
        }
        $datos->name = $request->name;
        $datos->description = $request->description;
        $datos->save();
        return response()->json(["message" => "success", "data" => $datos]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = Lot::find($id);
        if (!$datos) {
            return response()->json(["message"=> "not found"],404);
        }
        $datos->delete();
        return response()->json(["message"=> "deleted record"],200);
    }
}
