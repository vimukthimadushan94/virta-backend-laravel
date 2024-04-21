<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStationRequest;
use App\Http\Requests\UpdateStationRequest;
use App\Models\Company;
use App\Models\Station;
use App\Repositories\StationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class StationController extends Controller
{
    protected $stationRepository;

    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    /**
     * @param StoreStationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreStationRequest $request)
    {
        $station = Station::create($request->all());
        return response()->json($station);
    }

    /**
     * @param UpdateStationRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * get all the stations from the given location and radius
     */
    public function getStationsWithinRadius(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');
        $companyId = $request->input('company_id');

        if(isset($latitude) && isset($longitude) && isset($radius)){
            $groupedStations = $this->stationRepository->getStations($latitude,$longitude,$radius,$companyId);
            return response()->json($groupedStations);
        }else{
            return response()->json(['error' => 'Station not found. Please provide location and range attributes'], 404);
        }

    }



}
