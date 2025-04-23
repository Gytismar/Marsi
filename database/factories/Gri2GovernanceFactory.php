<?php

namespace Database\Factories;

use App\Models\Gri2Governance;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gri2GovernanceFactory extends Factory
{
    protected $model = Gri2Governance::class;

    public function definition(): array
    {
        $frequencies = ['Kartą per ketvirtį', 'Du kartus per metus', 'Kartą per metus'];
        $yesNoSentences = ['Taip, suformuluota atsakomybė ir paskirstyta tarp padalinių.', 'Ne, kol kas neįgyvendinta.'];

        return [
            'company_id' => Company::factory(),
            'reporting_year' => $this->faker->year(),
            'governance_structure' => $this->faker->randomElement([
                'Vienpakopė valdymo sistema',
                'Dvipakopė valdymo sistema',
                'Kita struktūra'
            ]),
            'board_size' => $this->faker->numberBetween(3, 15),
            'independent_members' => $this->faker->numberBetween(0, 10),
            'chair_is_executive' => $this->faker->boolean(),
            'delegation_of_responsibility' => $this->faker->randomElement($yesNoSentences),
            'reporting_frequency' => $this->faker->randomElement($frequencies),
            'board_review_of_esg' => $this->faker->boolean(),
            'conflict_of_interest_policy' => $this->faker->boolean(),
            'policy_code_of_ethics' => $this->faker->boolean(),
            'ethics_advice_mechanism' => $this->faker->randomElement([
                'Etikos linija arba vidaus konsultavimo paslauga',
                'Nėra aiškios konsultavimo sistemos'
            ]),
            'report_misconduct_mechanism' => $this->faker->randomElement([
                'Anoniminė pranešimų sistema',
                'Pranešimas tiesioginiam vadovui',
                'Neapibrėžta'
            ]),
            'compliance_violations_count' => $this->faker->numberBetween(0, 10),
            'compliance_fines_value' => $this->faker->randomFloat(2, 0, 100000),
        ];
    }
}
