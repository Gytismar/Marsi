<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\User;
use App\Models\Gri302Energy;
use App\Models\Gri303Water;
use App\Models\Gri305Emission;
use App\Models\Gri306Waste;
use App\Models\Gri403HealthSafety;
use App\Models\Gri2Governance;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function test_fillable_fields()
    {
        $company = new Company([
            'company_name' => 'Mock Co',
            'industry' => 'Tech',
            'country' => 'Estonia',
            'size' => 'Small',
            'company_code' => 'MOCK123',
            'user_id' => 7,
        ]);

        $this->assertSame('Mock Co', $company->company_name);
        $this->assertSame('Tech', $company->industry);
        $this->assertSame('Estonia', $company->country);
        $this->assertSame('Small', $company->size);
        $this->assertSame('MOCK123', $company->company_code);
        $this->assertSame(7, $company->user_id);
    }

    public function test_user_relationship()
    {
        $company = new Company();

        $relation = $company->user();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }

    public function test_gri302_energy_relationship()
    {
        $company = new Company();

        $relation = $company->gri302Energy();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('company_id', $relation->getForeignKeyName());
        $this->assertEquals(Gri302Energy::class, $relation->getRelated()::class);
    }

    public function test_gri303_water_relationship()
    {
        $company = new Company();

        $relation = $company->gri303Water();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('company_id', $relation->getForeignKeyName());
        $this->assertEquals(Gri303Water::class, $relation->getRelated()::class);
    }

    public function test_gri305_emissions_relationship()
    {
        $company = new Company();

        $relation = $company->gri305Emissions();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('company_id', $relation->getForeignKeyName());
        $this->assertEquals(Gri305Emission::class, $relation->getRelated()::class);
    }

    public function test_gri306_waste_relationship()
    {
        $company = new Company();

        $relation = $company->gri306Waste();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('company_id', $relation->getForeignKeyName());
        $this->assertEquals(Gri306Waste::class, $relation->getRelated()::class);
    }

    public function test_gri403_health_safety_relationship()
    {
        $company = new Company();

        $relation = $company->gri403HealthSafety();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('company_id', $relation->getForeignKeyName());
        $this->assertEquals(Gri403HealthSafety::class, $relation->getRelated()::class);
    }

    public function test_gri2_governance_relationship()
    {
        $company = new Company();

        $relation = $company->gri2Governance();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('company_id', $relation->getForeignKeyName());
        $this->assertEquals(Gri2Governance::class, $relation->getRelated()::class);
    }
}
