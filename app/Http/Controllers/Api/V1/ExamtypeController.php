<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Examtype;
use Illuminate\Http\Request;

class ExamtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examtype = Examtype::all();
        return response()->json($examtype);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Examtype();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $batch = Examtype::find($id);
        return response()->json($batch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Examtype::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();
        return response()->json($data);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Examtype::find($id);
        if (!$data) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
