<?php

namespace Service;

use App\Models\Company;
use App\Models\Gri306Waste;
use App\Models\User;
use App\Services\Gri306WasteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Gri306WasteServiceTest extends TestCase
{
    use RefreshDatabase;

    protected Gri306WasteService $service;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Auth::shouldReceive('id')->andReturn($user->id);

        $this->company = Company::factory()->create([
            'user_id' => $user->id,
            'company_code' => 'WASTE123',
        ]);

        Gri306Waste::factory()->create(['company_id' => $this->company->id]);

        $this->service = new Gri306WasteService();
    }

    public function test_get_all() { $this->assertNotEmpty($this->service->getAll()); }
    public function test_get_by_id() { $item = Gri306Waste::first(); $this->assertEquals($item->id, $this->service->getById($item->id)->id); }
    public function test_create() { $data = Gri306Waste::factory()->make(['company_id' => $this->company->id])->toArray(); $this->assertDatabaseHas('gri_306_waste', ['id' => $this->service->create($data)->id]); }
    public function test_update() { $item = Gri306Waste::first(); $this->assertEquals(123.45, $this->service->update($item->id, ['total_waste_generated' => 123.45])->total_waste_generated); }
    public function test_delete() { $item = Gri306Waste::first(); $this->service->delete($item->id); $this->assertDatabaseMissing('gri_306_waste', ['id' => $item->id]); }
    public function test_bulk_create() { $rows = Gri306Waste::factory()->count(2)->make(['company_id' => $this->company->id])->map(fn($item) => $item->toArray())->toArray(); $this->assertCount(2, $this->service->bulkCreate($rows)); }
    public function test_get_schema() { $schema = $this->service->getSchema(); $this->assertIsArray($schema); $this->assertNotContains('id', $schema); $this->assertNotContains('company_id', $schema); }
}
