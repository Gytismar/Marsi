<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        $industries = ['Informacinės technologijos', 'Gamyba', 'Finansai', 'Sveikatos priežiūra', 'Transportas'];
        $countries = ['Lietuva', 'Latvija', 'Estija'];
        $sizes = ['Maža', 'Vidutinė', 'Didelė'];

        return [
            'company_name' => $this->faker->company(),
            'industry' => $this->faker->randomElement($industries),
            'country' => $this->faker->randomElement($countries),
            'size' => $this->faker->randomElement($sizes),
        ];
    }
}
