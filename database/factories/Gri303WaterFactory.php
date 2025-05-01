<?php

namespace Database\Factories;

use App\Models\Gri303Water;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gri303WaterFactory extends Factory
{
    protected $model = Gri303Water::class;

    public function definition(): array
    {
        $dischargeDestinations = ['Upė', 'Valymo įrenginiai', 'Jūra', 'Viešasis tinklas'];

        return [
            'company_id' => Company::factory(),
            'reporting_year' => $this->faker->year(),
            'water_withdrawn' => $this->faker->randomFloat(2, 100, 10000),
            'water_discharge' => $this->faker->randomFloat(2, 50, 8000),
            'discharge_destination' => $this->faker->randomElement($dischargeDestinations),
            'water_consumption' => $this->faker->randomFloat(2, 50, 9000),
            'water_recycled' => $this->faker->randomFloat(2, 0, 5000),
            'unit' => 'm³',
            'source' => 'Metinis ataskaitos dokumentas',
        ];
    }
}
