<?php

namespace Service;

use App\Models\Company;
use App\Models\User;
use App\Services\CompanyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CompanyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CompanyService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Auth::shouldReceive('id')->andReturn($user->id);

        $this->service = new CompanyService();

        Company::factory()->create([
            'user_id' => $user->id,
            'company_code' => 'TEST123',
        ]);
    }

    public function test_get_all()
    {
        $result = $this->service->getAll();
        $this->assertGreaterThanOrEqual(1, $result->count());
    }

    public function test_create()
    {
        $created = $this->service->create([
            'company_name' => 'TestCo',
            'company_code' => 'TEST999',
            'industry' => 'IT',
            'country' => 'Lithuania',
            'size' => 'Maža',
        ]);

        $this->assertDatabaseHas('companies', ['id' => $created->id]);
    }

    public function test_get_by_id()
    {
        $company = Company::first();
        $found = $this->service->getById($company->id);

        $this->assertEquals($company->id, $found->id);
    }
}
