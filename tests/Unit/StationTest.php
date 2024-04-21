<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Station;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class StationTest extends TestCase
{
//    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        Artisan::call('db:seed --env=testing');
    }
    /**
     * test cases for create company
     */
    public function test_can_create_station_with_valid_data(): void
    {
        $randomCompany = Company::inRandomOrder()->first();
        $randomCompanyId = $randomCompany->id;

        $data = [
            'company_id'    => $randomCompanyId,
            'name'          => 'Test Station',
            'latitude'      => 61.489180,
            'longitude'     => 23.755233,
            'address'       => 'Test address',
        ];
        $response = $this->postJson('/api/station',$data);
        $response->assertStatus(201);
    }

    public function test_create_station_without_required_fields(): void
    {
        $response = $this->postJson('/api/station', []);

        $response->assertStatus(422);
    }

    public function test_update_station_with_valid_data():void
    {
        $station = Station::factory()->create();
        $randomCompany = Company::inRandomOrder()->first();
        $randomCompanyId = $randomCompany->id;

        $updateData = [
            'company_id'    => $randomCompanyId,
            'name'          => 'Test Updated Station',
            'latitude'      => 63.489180,
            'longitude'     => 26.755233,
            'address'       => 'Test updated address',
        ];

        $response = $this->putJson('/api/station/' . $station->id, $updateData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'company_id' => $updateData['company_id'],
                'name' => $updateData['name'],
                'latitude' => $updateData['latitude'],
                'longitude' => $updateData['longitude'],
                'address' => $updateData['address'],
            ]);

    }

    public function test_delete_existing_station()
    {
        $station = Station::factory()->create();

        $response = $this->deleteJson('/api/station/' . $station->id);

        $response->assertStatus(200);
    }

    public function test_returns_404_if_station_not_found()
    {
        $response = $this->deleteJson('/api/station/9999');

        $response->assertStatus(404);
    }

    public function test_returns_list_of_stations_within_radius()
    {
        $latitude = 65.004716; //finland range
        $longitude = 25.505825; //finland range
        $range = 800;
        $response = $this->getJson("/api/station/get-by-range?latitude=latitude={$latitude}&longitude={$longitude}&radius={$range}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                '*' => [
                    'location' => [
                        'latitude',
                        'longitude',
                        'distance',
                    ],
                    'stations' => [
                        '*' => [
                            'id',
                            'name',
                            'latitude',
                            'longitude',
                            'company_id',
                            'address',
                            'company' => [
                                'id',
                                'parent_company_id',
                                'name',
                                'created_at',
                                'updated_at',
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
