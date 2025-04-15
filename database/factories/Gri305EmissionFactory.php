<?php

namespace Database\Factories;

use App\Models\Gri305Emission;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gri305EmissionFactory extends Factory
{
    protected $model = Gri305Emission::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'reporting_year' => $this->faker->year(),
            'scope_1' => $this->faker->randomFloat(2, 100, 10000),
            'scope_2' => $this->faker->randomFloat(2, 100, 8000),
            'scope_3' => $this->faker->randomFloat(2, 100, 15000),
            'ghg_intensity' => $this->faker->randomFloat(2, 0.1, 50.0),
        ];
    }
}
