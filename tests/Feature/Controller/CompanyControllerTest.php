<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\CompanyController;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function testIndexReturnsCompanies()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('getAttribute')->with('companies')->andReturn([
            ['id' => 1, 'company_name' => 'TestCo']
        ]);

        Auth::shouldReceive('user')->andReturn($user);

        $controller = new CompanyController();
        $response = $controller->index();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('TestCo', $response->getContent());
    }

    public function testStoreCreatesCompany()
    {
        $input = [
            'company_name' => 'TestCo',
            'company_code' => 'TST123',
            'industry' => 'IT',
            'country' => 'Lithuania',
            'size' => 'Medium',
        ];

        $request = Mockery::mock(Request::class)->makePartial();
        $request->shouldReceive('validate')->once()->andReturn($input);

        $companyModel = new Company(['id' => 1] + $input);

        $companiesRelation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
        $companiesRelation->shouldReceive('create')->once()->with($input)->andReturn($companyModel);

        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('companies')->andReturn($companiesRelation);

        Auth::shouldReceive('user')->andReturn($user);

        $controller = new CompanyController();
        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('TestCo', $response->getContent());
    }

    public function testShowReturnsCompany()
    {
        $company = new Company(['id' => 1, 'company_name' => 'TestCo']);

        $relation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
        $relation->shouldReceive('findOrFail')->with(1)->andReturn($company);

        $user = Mockery::mock(User::class);
        $user->shouldReceive('companies')->andReturn($relation);

        Auth::shouldReceive('user')->andReturn($user);

        $controller = new CompanyController();
        $response = $controller->show(1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('TestCo', $response->getContent());
    }

    public function testShowThrowsModelNotFoundException()
    {
        $this->expectException(ModelNotFoundException::class);

        $relation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
        $relation->shouldReceive('findOrFail')->with(999)->andThrow(ModelNotFoundException::class);

        $user = Mockery::mock(User::class);
        $user->shouldReceive('companies')->andReturn($relation);

        Auth::shouldReceive('user')->andReturn($user);

        $controller = new CompanyController();
        $controller->show(999); // Should throw
    }

    public function testUpdateCompany()
    {
        $company = Mockery::mock(Company::class)->makePartial();
        $company->id = 1;

        $input = ['company_name' => 'UpdatedCo'];

        $request = Mockery::mock(Request::class)->makePartial();
        $request->shouldReceive('validate')->once()->andReturn($input);

        $relation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
        $relation->shouldReceive('findOrFail')->with(1)->andReturn($company);

        $company->shouldReceive('update')->once()->with($input)->andReturnTrue();

        $user = Mockery::mock(User::class);
        $user->shouldReceive('companies')->andReturn($relation);

        Auth::shouldReceive('user')->andReturn($user);

        $controller = new CompanyController();
        $response = $controller->update($request, 1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testDestroyCompany()
    {
        $company = Mockery::mock(Company::class);
        $company->shouldReceive('delete')->once()->andReturnTrue();

        $relation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
        $relation->shouldReceive('findOrFail')->with(1)->andReturn($company);

        $user = Mockery::mock(User::class);
        $user->shouldReceive('companies')->andReturn($relation);

        Auth::shouldReceive('user')->andReturn($user);

        $controller = new CompanyController();
        $response = $controller->destroy(1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Deleted successfully', $response->getContent());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
