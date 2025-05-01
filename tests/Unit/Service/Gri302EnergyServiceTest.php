<?php

namespace Service;

use App\Models\Company;
use App\Models\Gri302Energy;
use App\Models\User;
use App\Services\Gri302EnergyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Gri302EnergyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected Gri302EnergyService $service;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Auth::shouldReceive('id')->andReturn($user->id);

        $this->company = Company::factory()->create([
            'user_id' => $user->id,
            'company_code' => 'TEST456',
        ]);

        Gri302Energy::factory()->create(['company_id' => $this->company->id]);

        $this->service = new Gri302EnergyService();
    }

    public function test_get_all()
    {
        $result = $this->service->getAll();
        $this->assertGreaterThanOrEqual(1, $result->count());
    }

    public function test_get_by_id()
    {
        $item = Gri302Energy::first();
        $result = $this->service->getById($item->id);
        $this->assertEquals($item->id, $result->id);
    }

    public function test_create()
    {
        $data = Gri302Energy::factory()->make(['company_id' => $this->company->id])->toArray();
        $created = $this->service->create($data);

        $this->assertDatabaseHas('gri_302_energy', ['id' => $created->id]);
    }

    public function test_update()
    {
        $item = Gri302Energy::first();
        $updated = $this->service->update($item->id, ['total_energy_consumed' => 123.45]);
        $this->assertEquals(123.45, $updated->total_energy_consumed);
    }

    public function test_delete()
    {
        $item = Gri302Energy::first();
        $this->service->delete($item->id);
        $this->assertDatabaseMissing('gri_302_energy', ['id' => $item->id]);
    }

    public function test_bulk_create()
    {
        $rows = Gri302Energy::factory()->count(2)->make([
            'company_id' => $this->company->id
        ])->map(fn($item) => $item->toArray())->toArray();

        $created = $this->service->bulkCreate($rows);

        $this->assertCount(2, $created);
    }

    public function test_get_schema()
    {
        $schema = $this->service->getSchema();
        $this->assertIsArray($schema);
        $this->assertNotContains('id', $schema);
        $this->assertNotContains('company_id', $schema);
    }

    public function test_create_without_company_id_sets_it_automatically()
    {
        Auth::shouldReceive('id')->andReturn($this->company->user_id);

        $data = Gri302Energy::factory()->make(['company_id' => null])->toArray();
        unset($data['company_id']);

        $created = $this->service->create($data);

        $this->assertDatabaseHas('gri_302_energy', ['id' => $created->id]);
        $this->assertEquals($this->company->id, $created->company_id);
    }
}
