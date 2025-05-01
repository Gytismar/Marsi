<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;
use App\Models\Gri2Governance;
use App\Services\Gri2GovernanceService;
use App\Http\Controllers\Gri2GovernanceController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

class Gri2GovernanceControllerTest extends TestCase
{
    private Gri2GovernanceService $service;
    private Gri2GovernanceController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(Gri2GovernanceService::class);
        $this->controller = new Gri2GovernanceController($this->service);
    }

    public function testIndex()
    {
        $model = new Gri2Governance($this->validPayload());
        $model->setAttribute('id', 1);

        $this->service->shouldReceive('getAll')
            ->once()
            ->andReturn(new Collection([$model]));

        $response = $this->controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = $response->getData(true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey(0, $data);
    }

    public function testShow()
    {
        $model = new Gri2Governance($this->validPayload());
        $model->setAttribute('id', 1);

        $this->service->shouldReceive('getById')->with(1)->once()->andReturn($model);

        $response = $this->controller->show(1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $response->getData(true));
        $this->assertEquals(1, $response->getData(true)['id']);
    }

    public function testStore()
    {
        $request = Request::create('/fake', 'POST', $this->validPayload());
        $this->app['router']->post('/fake', fn () => null);

        $model = new Gri2Governance($this->validPayload());
        $model->setAttribute('id', 1);

        $this->service->shouldReceive('create')->once()->andReturn($model);

        $response = $this->controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertArrayHasKey('id', $response->getData(true));
        $this->assertEquals(1, $response->getData(true)['id']);
    }

    public function testUpdate()
    {
        $request = Request::create('/fake', 'PUT', $this->validPayload());
        $this->app['router']->put('/fake', fn () => null);

        $model = new Gri2Governance($this->validPayload());
        $model->setAttribute('id', 1);

        $this->service->shouldReceive('update')->with(1, Mockery::type('array'))->once()->andReturn($model);

        $response = $this->controller->update($request, 1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('id', $response->getData(true));
        $this->assertEquals(1, $response->getData(true)['id']);
    }

    public function testDestroy()
    {
        $this->service->shouldReceive('delete')->with(1)->once();
        $response = $this->controller->destroy(1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'Deleted successfully'], $response->getData(true));
    }

    public function testSchema()
    {
        $this->service->shouldReceive('getSchema')->once()->andReturn(['field1', 'field2']);
        $response = $this->controller->schema();

        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getData(true);

        $this->assertArrayHasKey('fields', $data);
        $this->assertArrayHasKey('required', $data);
        $this->assertContains('field1', $data['fields']);
    }

    public function testBulkImport()
    {
        $payload = [$this->validPayload()];
        $request = Request::create('/bulk', 'POST', [], [], [], [], json_encode($payload));
        $request->setJson($payload);

        $model = new Gri2Governance($payload[0]);
        $model->setAttribute('id', 1);

        $this->service->shouldReceive('bulkCreate')->once()->andReturn([$model]);

        $response = $this->controller->bulkImport($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals([
            'message' => 'Bulk import completed.',
            'imported' => 1,
        ], $response->getData(true));
    }

    private function validPayload(): array
    {
        return [
            'reporting_year' => 2023,
            'governance_structure' => 'Board-led',
            'board_size' => 10,
            'independent_members' => 6,
            'chair_is_executive' => false,
            'delegation_of_responsibility' => 'CEO',
            'reporting_frequency' => 'quarterly',
            'board_review_of_esg' => true,
            'conflict_of_interest_policy' => true,
            'policy_code_of_ethics' => true,
            'ethics_advice_mechanism' => 'hotline',
            'report_misconduct_mechanism' => 'email',
            'compliance_violations_count' => 0,
            'compliance_fines_value' => 0.00,
        ];
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
