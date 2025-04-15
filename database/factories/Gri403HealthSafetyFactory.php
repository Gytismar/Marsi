<?php

namespace Database\Factories;

use App\Models\Gri403HealthSafety;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gri403HealthSafetyFactory extends Factory
{
    protected $model = Gri403HealthSafety::class;

    public function definition(): array
    {
        $coverageOptions = ['Visa organizacija', 'Dalis padalinių', 'Neturi'];

        return [
            'company_id' => Company::factory(),
            'reporting_year' => $this->faker->year(),
            'total_workforce' => $this->faker->numberBetween(10, 1000),
            'incidents_of_injury' => $this->faker->numberBetween(0, 50),
            'lost_days' => $this->faker->numberBetween(0, 500),
            'fatalities' => $this->faker->optional()->numberBetween(0, 5),
            'health_safety_training' => $this->faker->randomFloat(2, 10, 1000),
            'management_system_coverage' => $this->faker->randomElement($coverageOptions),
        ];
    }
}
