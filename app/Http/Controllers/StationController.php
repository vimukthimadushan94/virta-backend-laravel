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
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="APIs for Virta",
     *      description="API for companies and stations",
     *      @OA\Contact(
     *          email="madushan.gangoda94@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * @OA\Post(
     *     path="/api/station",
     *     summary="Create a new station",
     *     tags={"Station"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Station data",
     *         @OA\JsonContent(
     *             required={"company_id", "name", "latitude", "longitude"},
     *             @OA\Property(property="company_id", type="integer", example="1"),
     *             @OA\Property(property="name", type="string", example="Station A"),
     *             @OA\Property(property="latitude", type="number", format="double", example="61.489180"),
     *             @OA\Property(property="longitude", type="number", format="double", example="23.755233"),
     *             @OA\Property(property="address", type="string", nullable=true, example="6a isokatu Helsinki")
     *         ),
     *     ),
     *     @OA\Response(response=201, description="Station created successfully"),
     *     @OA\Response(response=400, description="Invalid data provided")
     * )
     */
    public function store(StoreStationRequest $request)
    {
        $station = Station::create($request->all());
        return response()->json($station,201);
    }

    /**
     * @param UpdateStationRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Put(
     *     path="/api/station/{id}",
     *     summary="Update an existing station",
     *     tags={"Station"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the station to update",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Station data",
     *         @OA\JsonContent(
     *             required={"company_id", "name", "latitude", "longitude"},
     *             @OA\Property(property="company_id", type="integer", example="1"),
     *             @OA\Property(property="name", type="string", example="Updated Station A"),
     *             @OA\Property(property="latitude", type="number", format="double", example="61.489180"),
     *             @OA\Property(property="longitude", type="number", format="double", example="23.755233"),
     *             @OA\Property(property="address", type="string", nullable=true, example="yliopistokatu oulu")
     *         ),
     *     ),
     *     @OA\Response(response=200, description="Station updated successfully"),
     *     @OA\Response(response=400, description="Invalid data provided"),
     *     @OA\Response(response=404, description="Station not found")
     * )
     */
    public function update(UpdateStationRequest $request, $id)
    {
        try {
            $station = Station::findOrFail($id);
            $station->update($request->all());
            return response()->json($station);
        }catch (ModelNotFoundException $exception){
            return response()->json(['error' => 'Station not found'], 404);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *     path="/api/station/{id}",
     *     summary="Delete a station",
     *     tags={"Station"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the station to delete",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Station deleted successfully"),
     *     @OA\Response(response=404, description="Station not found")
     * )
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
     * @OA\Get(
     *     path="/api/station/get-by-range",
     *     summary="Get a list of stations",
     *     tags={"Station"},
     *     @OA\Parameter(
     *          name="latitude",
     *          in="query",
     *          description="Latitude of the location",
     *          required=false,
     *          @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *          name="longitude",
     *          in="query",
     *          description="Longitude of the location",
     *          required=false,
     *          @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *          name="radius",
     *          in="query",
     *          description="Search radius in kilo meters",
     *          required=false,
     *          @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *          name="company_id",
     *          in="query",
     *          description="Company ID",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Station not found. Please provide location and range attributes")
     * )
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
