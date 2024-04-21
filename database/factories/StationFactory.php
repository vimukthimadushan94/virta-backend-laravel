<?php

namespace Database\Factories;

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
        return [
            'name' => $this->faker->company,
            'company_id' => rand(6,9),
            'latitude' => $this->faker->latitude(60,70),//finland range
            'longitude' => $this->faker->longitude(20,32),//finland range
            'address' => $this->faker->address,
        ];
    }
}
