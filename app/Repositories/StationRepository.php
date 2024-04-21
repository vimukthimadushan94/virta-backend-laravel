<?php

namespace App\Repositories;

use App\Models\Station;

class StationRepository
{
    public function getStations($latitude,$longitude,$radius)
    {
        $stations = Station::selectRaw("*,
                    ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) )
                      * cos( radians( longitude ) - radians(?)
                      ) + sin( radians(?) ) * sin( radians( latitude ) ) )
                    ) AS distance", [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->get();

        $groupedStations = $stations->groupBy(function ($station) {
            return $station->latitude . '_' . $station->longitude;
        })->map(function ($group) {
            return [
                'location' => [
                    'latitude' => $group->first()->latitude,
                    'longitude' => $group->first()->longitude,
                    'distance' => $group->first()->distance,
                ],
                'stations' => $group->map(function ($station) {
                    return [
                        'id' => $station->id,
                        'name' => $station->name,
                        'latitude' => $station->latitude,
                        'longitude' => $station->longitude,
                        'company_id' => $station->company_id,
                        'address' => $station->address,
                        'company' => $station->company()->get(),
                    ];
                })->toArray(),
            ];
        })->values()->toArray();

        return $groupedStations;

    }
}
