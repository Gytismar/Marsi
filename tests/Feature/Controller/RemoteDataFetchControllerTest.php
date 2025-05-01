<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\RemoteDataFetchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RemoteDataFetchControllerTest extends TestCase
{
    public function testFetchReturnsCsvOnSuccess()
    {
        Http::fake([
            'https://example.com/data' => Http::response('id,name\n1,Alice\n2,Bob', 200, [
                'Content-Type' => 'text/csv',
            ]),
        ]);

        $controller = new RemoteDataFetchController();

        $request = Request::create('/fake', 'POST', [
            'url' => 'https://example.com/data',
            'username' => 'user',
            'password' => 'pass',
        ]);

        $response = $controller->fetch($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('id,name\n1,Alice\n2,Bob', $response->getContent());
        $this->assertEquals('text/csv', $response->headers->get('Content-Type'));
    }

    public function testFetchReturnsErrorOnFailure()
    {
        Http::fake([
            'https://example.com/data' => Http::response('Access denied', 403),
        ]);

        $controller = new RemoteDataFetchController();

        $request = Request::create('/fake', 'POST', [
            'url' => 'https://example.com/data',
            'username' => 'user',
            'password' => 'pass',
        ]);

        $response = $controller->fetch($request);

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Failed to fetch CSV', 'details' => 'Access denied']),
            $response->getContent()
        );
    }

    public function testFetchReturnsValidationErrors()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller = new RemoteDataFetchController();

        $request = Request::create('/fake', 'POST', [
            // Intentionally empty to trigger validation failure
        ]);

        $controller->fetch($request);
    }

    public function testFetchHandlesException()
    {
        Http::fake([
            'https://example.com/data' => fn () => throw new \Exception('Network error'),
        ]);

        $controller = new RemoteDataFetchController();

        $request = Request::create('/fake', 'POST', [
            'url' => 'https://example.com/data',
            'username' => 'user',
            'password' => 'pass',
        ]);

        $response = $controller->fetch($request);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Something went wrong', 'message' => 'Network error']),
            $response->getContent()
        );
    }
}
