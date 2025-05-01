<?php

namespace Service;

use App\Models\Company;
use App\Models\Gri403HealthSafety;
use App\Models\User;
use App\Services\Gri403HealthSafetyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Gri403HealthSafetyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected Gri403HealthSafetyService $service;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Auth::shouldReceive('id')->andReturn($user->id);

        $this->company = Company::factory()->create([
            'user_id' => $user->id,
            'company_code' => 'SAFETY123',
        ]);

        Gri403HealthSafety::factory()->create(['company_id' => $this->company->id]);

        $this->service = new Gri403HealthSafetyService();
    }

    public function test_get_all() { $this->assertNotEmpty($this->service->getAll()); }
    public function test_get_by_id() { $item = Gri403HealthSafety::first(); $this->assertEquals($item->id, $this->service->getById($item->id)->id); }
    public function test_create() { $data = Gri403HealthSafety::factory()->make(['company_id' => $this->company->id])->toArray(); $this->assertDatabaseHas('gri_403_health_safety', ['id' => $this->service->create($data)->id]); }
    public function test_update() { $item = Gri403HealthSafety::first(); $this->assertEquals(200, $this->service->update($item->id, ['total_workforce' => 200])->total_workforce); }
    public function test_delete() { $item = Gri403HealthSafety::first(); $this->service->delete($item->id); $this->assertDatabaseMissing('gri_403_health_safety', ['id' => $item->id]); }
    public function test_bulk_create() { $rows = Gri403HealthSafety::factory()->count(2)->make(['company_id' => $this->company->id])->map(fn($item) => $item->toArray())->toArray(); $this->assertCount(2, $this->service->bulkCreate($rows)); }
    public function test_get_schema() { $schema = $this->service->getSchema(); $this->assertIsArray($schema); $this->assertNotContains('id', $schema); $this->assertNotContains('company_id', $schema); }
}
