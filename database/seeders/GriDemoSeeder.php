<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Gri302Energy;
use App\Models\Gri303Water;
use App\Models\Gri305Emission;
use App\Models\Gri306Waste;
use App\Models\Gri2Governance;
use App\Models\Gri403HealthSafety;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GriDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Jonas Petrauskas',
            'email' => 'jonas.petrauskas@example.lt',
            'email_verified_at' => now(),
            'password' => Hash::make('slaptazodis123'),
            'remember_token' => Str::random(10),
        ]);

        $company = Company::create([
            'user_id' => $user->id,
            'company_name' => 'UAB Žalias Vėjas',
            'company_code' => '305678901',
            'industry' => 'Informacinės technologijos',
            'country' => 'Lietuva',
            'size' => '9',
        ]);

        $energySources = ['Vėjo jėgainės', 'Saulės elektrinė', 'Gamtinės dujos', 'Dyzeliniai generatoriai'];
        $waterSources = ['Miestų vandentiekis', 'Gręžinys'];
        $dischargeDestinations = ['Gamtinis telkinys', 'Kanalizacija'];
        $wasteDisposalMethods = ['Perdirbimas', 'Sąvartynas', 'Degimas energijai gauti'];
        $reportingFrequencies = ['Kartą per metus', 'Du kartus per metus'];

        foreach (range(2020, 2025) as $year) {

            // --- GRI 302: Energy ---
            foreach ($energySources as $source) {
                $renewableSources = ['Vėjo jėgainės', 'Saulės elektrinė'];
                $isRenewable = in_array($source, $renewableSources);
                $energyConsumed = rand(1000, 3000); // Smaller company, lower energy use

                Gri302Energy::create([
                    'company_id' => $company->id,
                    'reporting_year' => $year,
                    'total_energy_consumed' => $energyConsumed,
                    'renewable_energy_consumed' => $isRenewable ? $energyConsumed : 0,
                    'nonrenewable_energy_consumed' => $isRenewable ? 0 : $energyConsumed,
                    'energy_consumed_unit' => 'kWh',
                    'energy_intensity' => round(rand(100, 300) / 10, 2), // 10.0 - 30.0
                    'reduction_achieved' => round(rand(5, 20) / 10, 2), // 0.5% - 2.0%
                    'source' => $source,
                ]);
            }

            // --- GRI 303: Water ---
            foreach ($waterSources as $source) {
                $waterWithdrawn = rand(500, 2000); // Smaller scale
                $waterDischarge = rand(0, (int)($waterWithdrawn * 0.7)); // Up to 70% discharge
                $waterConsumption = $waterWithdrawn - $waterDischarge;
                $waterRecycled = rand(0, (int)($waterConsumption * 0.5)); // Up to 50% recycled

                Gri303Water::create([
                    'company_id' => $company->id,
                    'reporting_year' => $year,
                    'water_withdrawn' => $waterWithdrawn,
                    'water_discharge' => $waterDischarge,
                    'discharge_destination' => $dischargeDestinations[array_rand($dischargeDestinations)],
                    'water_consumption' => $waterConsumption,
                    'water_recycled' => $waterRecycled,
                    'unit' => 'm³',
                    'source' => $source,
                ]);
            }

            // --- GRI 305: Emissions ---
            $scope1 = rand(10, 100); // Direct emissions
            $scope2 = rand(5, 50);   // Indirect electricity emissions
            $scope3 = rand(1, 30);   // Other emissions

            Gri305Emission::create([
                'company_id' => $company->id,
                'reporting_year' => $year,
                'scope_1' => $scope1,
                'scope_2' => $scope2,
                'scope_3' => $scope3,
                'ghg_intensity' => round(rand(10, 50) / 10, 2), // 1.0 - 5.0
            ]);

            // --- GRI 306: Waste ---
            foreach (['Hazardous', 'Nonhazardous'] as $wasteType) {
                $wasteAmount = $wasteType === 'Hazardous' ? rand(5, 50) : rand(100, 500);
                $wasteRecycled = rand(0, (int)($wasteAmount * 0.5));
                $wasteDisposed = $wasteAmount - $wasteRecycled;

                Gri306Waste::create([
                    'company_id' => $company->id,
                    'reporting_year' => $year,
                    'total_waste_generated' => $wasteAmount,
                    'hazardous_waste_generated' => $wasteType === 'Hazardous' ? $wasteAmount : 0,
                    'nonhazardous_waste_generated' => $wasteType === 'Nonhazardous' ? $wasteAmount : 0,
                    'waste_recycled' => $wasteRecycled,
                    'waste_disposed' => $wasteDisposed,
                    'disposal_method' => $wasteDisposalMethods[array_rand($wasteDisposalMethods)],
                ]);
            }

            // --- GRI 2: Governance ---
            Gri2Governance::create([
                'company_id' => $company->id,
                'reporting_year' => $year,
                'governance_structure' => 'Dviejų lygių valdymo struktūra',
                'board_size' => rand(3, 8),
                'independent_members' => rand(0, 3),
                'chair_is_executive' => (bool)rand(0, 1),
                'delegation_of_responsibility' => 'ESG atsakomybė perduodama valdymo komitetui.',
                'reporting_frequency' => $reportingFrequencies[array_rand($reportingFrequencies)],
                'board_review_of_esg' => (bool)rand(0, 1),
                'conflict_of_interest_policy' => true,
                'policy_code_of_ethics' => true,
                'ethics_advice_mechanism' => 'Anoniminė karštoji linija ir el. paštas.',
                'report_misconduct_mechanism' => 'Speciali internetinė pranešimų sistema.',
                'compliance_violations_count' => rand(0, 2),
                'compliance_fines_value' => round(rand(0, 5000) + rand(0, 99) / 100, 2),
            ]);

            // --- GRI 403: Health & Safety ---
            Gri403HealthSafety::create([
                'company_id' => $company->id,
                'reporting_year' => $year,
                'total_workforce' => rand(20, 50),
                'incidents_of_injury' => rand(0, 3),
                'lost_days' => rand(0, 50),
                'fatalities' => rand(0, 1),
                'health_safety_training' => round(rand(100, 400) + rand(0, 99) / 100, 2),
                'management_system_coverage' => rand(80, 100) . '%',
            ]);
        }
    }
}
