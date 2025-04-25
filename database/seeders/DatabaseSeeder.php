<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Gri302Energy;
use App\Models\Gri303Water;
use App\Models\Gri305Emission;
use App\Models\Gri306Waste;
use App\Models\Gri403HealthSafety;
use App\Models\Gri2Governance;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(GriDemoSeeder::class);
//        Company::factory()
//            ->count(10)
//            ->create()
//            ->each(function ($company) {
//                Gri302Energy::factory()->count(2)->create(['company_id' => $company->id]);
//                Gri303Water::factory()->count(2)->create(['company_id' => $company->id]);
//                Gri305Emission::factory()->count(1)->create(['company_id' => $company->id]);
//                Gri306Waste::factory()->count(1)->create(['company_id' => $company->id]);
//                Gri403HealthSafety::factory()->count(1)->create(['company_id' => $company->id]);
//                Gri2Governance::factory()->count(1)->create(['company_id' => $company->id]);
//            });
    }
}
