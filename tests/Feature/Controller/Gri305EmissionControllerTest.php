<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;
use App\Models\Gri305Emission;
use App\Services\Gri305EmissionService;
use App\Http\Controllers\Gri305EmissionController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

class Gri305EmissionControllerTest extends TestCase
{
    private Gri305EmissionService $service;
    private Gri305EmissionController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(Gri305EmissionService::class);
        $this->controller = new Gri305EmissionController($this->service);
    }

    public function testIndex()
    {
        $model = new Gri305Emission($this->validPayload());
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
        $model = new Gri305Emission($this->validPayload());
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

        $model = new Gri305Emission($this->validPayload());
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

        $model = new Gri305Emission($this->validPayload());
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

        $model = new Gri305Emission($payload[0]);
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
            'scope_1' => 100.5,
            'scope_2' => 200.7,
            'scope_3' => 50.3,
            'ghg_intensity' => 1.5,
        ];
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
