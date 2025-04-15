<?php

namespace Database\Factories;

use App\Models\Gri306Waste;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gri306WasteFactory extends Factory
{
    protected $model = Gri306Waste::class;

    public function definition(): array
    {
        $methods = ['Deginta', 'Perdirbta', 'Sąvartynas', 'Kita'];

        $total = $this->faker->randomFloat(2, 100, 10000);
        $hazardous = $this->faker->randomFloat(2, 10, $total * 0.3);
        $nonhazardous = $total - $hazardous;
        $recycled = $this->faker->randomFloat(2, 0, $total);
        $disposed = $total - $recycled;

        return [
            'company_id' => Company::factory(),
            'reporting_year' => $this->faker->year(),
            'total_waste_generated' => $total,
            'hazardous_waste_generated' => $hazardous,
            'nonhazardous_waste_generated' => $nonhazardous,
            'waste_recycled' => $recycled,
            'waste_disposed' => $disposed,
            'disposal_method' => $this->faker->randomElement($methods),
        ];
    }
}
