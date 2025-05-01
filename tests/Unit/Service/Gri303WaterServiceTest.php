<?php

namespace Service;

use App\Models\Company;
use App\Models\Gri303Water;
use App\Models\User;
use App\Services\Gri303WaterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Gri303WaterServiceTest extends TestCase
{
    use RefreshDatabase;

    protected Gri303WaterService $service;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Auth::shouldReceive('id')->andReturn($user->id);

        $this->company = Company::factory()->create([
            'user_id' => $user->id,
            'company_code' => 'WATER123',
        ]);

        Gri303Water::factory()->create(['company_id' => $this->company->id]);

        $this->service = new Gri303WaterService();
    }

    public function test_get_all() { $this->assertNotEmpty($this->service->getAll()); }
    public function test_get_by_id() { $item = Gri303Water::first(); $this->assertEquals($item->id, $this->service->getById($item->id)->id); }
    public function test_create() { $data = Gri303Water::factory()->make(['company_id' => $this->company->id])->toArray(); $this->assertDatabaseHas('gri_303_water', ['id' => $this->service->create($data)->id]); }
    public function test_update() { $item = Gri303Water::first(); $this->assertEquals(999.99, $this->service->update($item->id, ['water_withdrawn' => 999.99])->water_withdrawn); }
    public function test_delete() { $item = Gri303Water::first(); $this->service->delete($item->id); $this->assertDatabaseMissing('gri_303_water', ['id' => $item->id]); }
    public function test_bulk_create() { $rows = Gri303Water::factory()->count(2)->make(['company_id' => $this->company->id])->map(fn($item) => $item->toArray())->toArray(); $this->assertCount(2, $this->service->bulkCreate($rows)); }
    public function test_get_schema() { $schema = $this->service->getSchema(); $this->assertIsArray($schema); $this->assertNotContains('id', $schema); $this->assertNotContains('company_id', $schema); }
}
