<?php

namespace Service;

use App\Models\Company;
use App\Models\Gri305Emission;
use App\Models\User;
use App\Services\Gri305EmissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Gri305EmissionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected Gri305EmissionService $service;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Auth::shouldReceive('id')->andReturn($user->id);

        $this->company = Company::factory()->create([
            'user_id' => $user->id,
            'company_code' => 'EMISS123',
        ]);

        Gri305Emission::factory()->create(['company_id' => $this->company->id]);

        $this->service = new Gri305EmissionService();
    }

    public function test_get_all() { $this->assertNotEmpty($this->service->getAll()); }
    public function test_get_by_id() { $item = Gri305Emission::first(); $this->assertEquals($item->id, $this->service->getById($item->id)->id); }
    public function test_create() { $data = Gri305Emission::factory()->make(['company_id' => $this->company->id])->toArray(); $this->assertDatabaseHas('gri_305_emissions', ['id' => $this->service->create($data)->id]); }
    public function test_update() { $item = Gri305Emission::first(); $this->assertEquals(321.45, $this->service->update($item->id, ['scope_1' => 321.45])->scope_1); }
    public function test_delete() { $item = Gri305Emission::first(); $this->service->delete($item->id); $this->assertDatabaseMissing('gri_305_emissions', ['id' => $item->id]); }
    public function test_bulk_create() { $rows = Gri305Emission::factory()->count(2)->make(['company_id' => $this->company->id])->map(fn($item) => $item->toArray())->toArray(); $this->assertCount(2, $this->service->bulkCreate($rows)); }
    public function test_get_schema() { $schema = $this->service->getSchema(); $this->assertIsArray($schema); $this->assertNotContains('id', $schema); $this->assertNotContains('company_id', $schema); }
}
