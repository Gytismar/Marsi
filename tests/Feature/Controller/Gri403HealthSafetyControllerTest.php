<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;
use App\Models\Gri403HealthSafety;
use App\Services\Gri403HealthSafetyService;
use App\Http\Controllers\Gri403HealthSafetyController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

class Gri403HealthSafetyControllerTest extends TestCase
{
    private Gri403HealthSafetyService $service;
    private Gri403HealthSafetyController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(Gri403HealthSafetyService::class);
        $this->controller = new Gri403HealthSafetyController($this->service);
    }

    public function testIndex()
    {
        $model = new Gri403HealthSafety($this->validPayload());
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
        $model = new Gri403HealthSafety($this->validPayload());
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

        $model = new Gri403HealthSafety($this->validPayload());
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

        $model = new Gri403HealthSafety($this->validPayload());
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

        $model = new Gri403HealthSafety($payload[0]);
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
            'total_workforce' => 120,
            'incidents_of_injury' => 5,
            'lost_days' => 10,
            'fatalities' => 0,
            'health_safety_training' => 85.5,
            'management_system_coverage' => 'full',
        ];
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
