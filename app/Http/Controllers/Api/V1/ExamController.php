<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->query("start_date");
        $endDate = $request->query("end_date");
        $type = $request->query("type");
        $query = Exam::with('examtype', 'lot')
            ->whereBetween('date', [$startDate, $endDate])
            ->where('examtype_id', $type)
            ->get();
        $count = count($query);
        $sumMedition = $query->sum('medition');
        $media = round($sumMedition / $count, 2);        
        
        $xixmediaPotencia = $query->reduce(function ($xixmedia, $value) use ($media) {
            $xixmedia2 = $value->medition - $media;            
            return pow($xixmedia2, 2) + $xixmedia;
        }, 0);    

        $desviacionStandar = sqrt($xixmediaPotencia/($count-1));        
        
        $coeficienteVariacion = $desviacionStandar / $media;

        $trisd = round(($media + (3 * $desviacionStandar)),7);
        $twosd = round(($media + (2 * $desviacionStandar)),7);
        $onesd = round(($media + $desviacionStandar),7);
        $onesdless = round(($media - $desviacionStandar),7);
        $twosdless = round(($media - (2 * $desviacionStandar)),7);
        $trisdless = round(($media - (3 * $desviacionStandar)),7);

        return response()->json([
            'message' => 'success', 
            'data' => $query,
            'total' => $count,
            'media' => $media,
            'ds' => $desviacionStandar,
            'cv' => $coeficienteVariacion,
            'sd3' => $trisd,
            'sd2' => $twosd,
            'sd1' => $onesd,
            'sdless1'=> $onesdless,
            'sdless2'=> $twosdless,
            'sdless3'=> $trisdless
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Exam();
        $data->date = $request->date;
        $data->medition = $request->medition;
        $data->examtype_id = $request->examtype_id;
        $data->lot_id = $request->lot_id;
        $data->save();
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exam = Exam::find($id);
        return response()->json($exam);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Exam::find($id);
        $data->date = $request->date;
        $data->medition = $request->medition;
        $data->examtype_id = $request->examtype_id;
        $data->lot_id = $request->lot_id;
        $data->save();
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exam = Exam::find($id);
        if(!$exam){
            return response()->json([
                'message'=> 'not found'
            ], 404);
        }
        $exam->delete();
        return response()->json([
            'message'=> 'deleted record',
            'data' => $exam
        ], 200);
    }
}
