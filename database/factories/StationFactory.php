<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Station>
 */
class StationFactory extends Factory
{
    protected $model = Station::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyIds = Company::pluck('id')->toArray();
        return [
            'name' => $this->faker->company.' Station',
            'company_id' => $this->faker->randomElement($companyIds),
            'latitude' => $this->faker->latitude(60,70),//finland range
            'longitude' => $this->faker->longitude(20,32),//finland range
            'address' => $this->faker->address,
        ];
    }
}
