<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LevelModel;


class LevelController extends Controller
{
    public function index(){
        return LevelModel::all();
    }

    public function store(Request $request){
        $level = LevelModel::create($request->all());

        return response()->json($level, 201);
    }

    public function show(LevelModel $level){
        return LevelModel::find($level);
    }

    public function update(Request $request, $level_id)
    {
        $level = LevelModel::where('level_id', $level_id)->first();

        if (!$level) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $level->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $level
        ]);
    }

    public function updateByKode(Request $request, $level_kode)
    {
        $level = LevelModel::where('level_kode', $level_kode)->first();

        if (!$level) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $level->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $level
        ]);
    }


    public function destroy($level_kode)
    {
        $level = LevelModel::where('level_kode', $level_kode)->first();

        if (!$level) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $level->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }

}