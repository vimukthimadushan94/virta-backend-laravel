<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStationRequest;
use App\Http\Requests\UpdateStationRequest;
use App\Models\Station;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function store(StoreStationRequest $request)
    {
        $station = Station::create($request->all());
        return response()->json($station);
    }

    public function update(UpdateStationRequest $request, $id)
    {
        try {
            $station = Station::findOrFail($id);
            $station->update($request->all());
            return response()->json($station);
        }catch (ModelNotFoundException $exception){
            return response()->json(['error' => 'Company not found'], 404);
        }

    }

    public function delete($id)
    {
        try {
            $station = Station::findOrFail($id);
            $station->delete();
            return response()->json($station);
        }catch (ModelNotFoundException $exception){
            return response()->json(['error' => 'Station not found'], 404);
        }
    }

}
