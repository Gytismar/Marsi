<?php

namespace Service;

use App\Models\Company;
use App\Models\Gri2Governance;
use App\Models\User;
use App\Services\Gri2GovernanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Gri2GovernanceServiceTest extends TestCase
{
    use RefreshDatabase;

    protected Gri2GovernanceService $service;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Auth::shouldReceive('id')->andReturn($user->id);

        $this->company = Company::factory()->create([
            'user_id' => $user->id,
            'company_code' => 'GOV123',
        ]);

        Gri2Governance::factory()->create(['company_id' => $this->company->id]);

        $this->service = new Gri2GovernanceService();
    }

    public function test_get_all() { $this->assertNotEmpty($this->service->getAll()); }
    public function test_get_by_id() { $item = Gri2Governance::first(); $this->assertEquals($item->id, $this->service->getById($item->id)->id); }
    public function test_create() { $data = Gri2Governance::factory()->make(['company_id' => $this->company->id])->toArray(); $this->assertDatabaseHas('gri_2_governance', ['id' => $this->service->create($data)->id]); }
    public function test_update() { $item = Gri2Governance::first(); $this->assertEquals('Annual', $this->service->update($item->id, ['reporting_frequency' => 'Annual'])->reporting_frequency); }
    public function test_delete() { $item = Gri2Governance::first(); $this->service->delete($item->id); $this->assertDatabaseMissing('gri_2_governance', ['id' => $item->id]); }
    public function test_bulk_create() { $rows = Gri2Governance::factory()->count(2)->make(['company_id' => $this->company->id])->map(fn($item) => $item->toArray())->toArray(); $this->assertCount(2, $this->service->bulkCreate($rows)); }
    public function test_get_schema() { $schema = $this->service->getSchema(); $this->assertIsArray($schema); $this->assertNotContains('id', $schema); $this->assertNotContains('company_id', $schema); }
}
