<?php

namespace Database\Factories;

use App\Models\Gri302Energy;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gri302EnergyFactory extends Factory
{
    protected $model = Gri302Energy::class;

    public function definition(): array
    {
        $units = ['kWh', 'MJ', 'GJ'];
        $sources = ['Apskaitos duomenys', 'Vidinės ataskaitos', 'Tiekėjų pateikta informacija'];

        return [
            'company_id' => Company::factory(),
            'reporting_year' => $this->faker->year(),
            'total_energy_consumed' => $this->faker->randomFloat(2, 1000, 100000),
            'renewable_energy_consumed' => $this->faker->randomFloat(2, 500, 50000),
            'nonrenewable_energy_consumed' => $this->faker->randomFloat(2, 500, 50000),
            'energy_consumed_unit' => $this->faker->randomElement($units),
            'energy_intensity' => $this->faker->optional()->randomFloat(2, 0.5, 10),
            'reduction_achieved' => $this->faker->optional()->randomFloat(2, 0, 5000),
            'source' => $this->faker->randomElement($sources),
        ];
    }
}
