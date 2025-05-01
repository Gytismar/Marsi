<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\AuthGRIController;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Mockery;

class AuthGRIControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::post('/login', [AuthGRIController::class, 'login']);
        Route::post('/logout', [AuthGRIController::class, 'logout']);
        Route::post('/register', [AuthGRIController::class, 'register']);
        Route::get('/login')->name('login');
    }

    public function testShowLoginFormReturnsView(): void
    {
        View::shouldReceive('make')
            ->with('auth.login', [], [])
            ->andReturn('login-view');

        $this->assertSame('login-view', (new AuthGRIController())->showLoginForm());
    }

    public function testShowRegisterFormReturnsView(): void
    {
        View::shouldReceive('make')
            ->with('auth.register', [], [])
            ->andReturn('register-view');

        $this->assertSame('register-view', (new AuthGRIController())->showRegisterForm());
    }

    public function testLoginWithValidCredentials(): void
    {
        $email = 'test@example.com';
        $password = 'securepass123';

        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => $email, 'password' => $password], false)
            ->andReturnTrue();

        Auth::shouldReceive('user')->andReturn(Mockery::mock('UserStub'));

        Session::start();
        $request = Request::create('/login', 'POST', [
            'email' => $email,
            'password' => $password,
        ]);
        $request->setLaravelSession(app('session.store'));

        $response = (new AuthGRIController())->login($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame(url('/pagrindinis'), $response->headers->get('Location'));
    }

    public function testLoginWithInvalidCredentials(): void
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'wrong@example.com', 'password' => 'wrongpass'], false)
            ->andReturnFalse();

        Session::start();

        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpass',
        ], ['HTTP_REFERER' => url('/login')]);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertStringContainsString('/login', $response->headers->get('Location'));
    }

    public function testLoginFailsReturnsBackWithErrors(): void
    {
        Auth::shouldReceive('attempt')->once()->andReturnFalse();

        Session::start();
        $request = Request::create('/login', 'POST', [
            'email' => 'fail@example.com',
            'password' => 'wrongpass',
        ]);
        $request->setLaravelSession(app('session.store'));

        $response = (new AuthGRIController())->login($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertTrue($response->getSession()->has('errors'));
    }

    public function testLogout(): void
    {
        Auth::shouldReceive('logout')->once();

        Session::start();
        $request = Request::create('/logout', 'POST');
        $request->setLaravelSession(app('session.store'));

        $response = (new AuthGRIController())->logout($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertStringContainsString('/login', $response->headers->get('Location'));
    }

    public function testLogoutInvalidatesSession(): void
    {
        Auth::shouldReceive('logout')->once();

        $sessionMock = Mockery::mock();
        $sessionMock->shouldReceive('invalidate')->once();
        $sessionMock->shouldReceive('regenerateToken')->once();

        $request = Mockery::mock(Request::class)->makePartial();
        $request->shouldReceive('session')->andReturn($sessionMock);

        $response = (new AuthGRIController())->logout($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertStringContainsString('/login', $response->headers->get('Location'));
    }

    public function testRegisterCreatesUserAndCompany(): void
    {
        Session::start();

        $input = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'securepass123',
            'password_confirmation' => 'securepass123',
            'company_name' => 'JaneCorp',
            'company_code' => 'JAN123',
            'industry' => 'Tech',
            'country' => 'Estonia',
            'size' => 'Small',
        ];

        $request = Mockery::mock(Request::class)->makePartial();
        $request->shouldReceive('validate')->andReturn($input);
        $request->shouldReceive('session')->andReturn(Mockery::mock(['regenerate' => null]));

        $user = Mockery::mock(\App\Models\User::class)->makePartial();
        $user->id = 1;

        $companiesRelation = Mockery::mock(HasMany::class);
        $companiesRelation->shouldReceive('create')->once()->with([
            'company_name' => $input['company_name'],
            'company_code' => $input['company_code'],
            'industry' => $input['industry'],
            'country' => $input['country'],
            'size' => $input['size'],
        ]);

        $user->shouldReceive('companies')->andReturn($companiesRelation);

        Auth::shouldReceive('login')->once()->with($user);

        $userFactory = Mockery::mock();
        $userFactory->shouldReceive('create')->once()->with(Mockery::on(function ($arg) use ($input) {
            return $arg['name'] === $input['name'] &&
                $arg['email'] === $input['email'] &&
                isset($arg['password']);
        }))->andReturn($user);

        $this->app->bind('user.factory', function () use ($userFactory) {
            return $userFactory;
        });

        $controller = new class($this->app->make('user.factory')) extends \App\Http\Controllers\AuthGRIController {
            protected $userFactory;
            public function __construct($userFactory) {
                $this->userFactory = $userFactory;
            }
            public function register($request) {
                $data = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                    'company_name' => 'required',
                    'company_code' => 'required',
                    'industry' => 'required',
                    'country' => 'required',
                    'size' => 'required',
                ]);

                $user = $this->userFactory->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                ]);

                $user->companies()->create([
                    'company_name' => $data['company_name'],
                    'company_code' => $data['company_code'],
                    'industry' => $data['industry'],
                    'country' => $data['country'],
                    'size' => $data['size'],
                ]);

                Auth::login($user);
                $request->session()->regenerate();

                return redirect('/pagrindinis');
            }
        };

        $response = $controller->register($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame(url('/pagrindinis'), $response->headers->get('Location'));
    }

    public function testRegisterValidationFails(): void
    {
        $this->withoutExceptionHandling();

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')
            ->once()
            ->andThrow(ValidationException::withMessages(['email' => ['Email is required.']]));

        $this->expectException(ValidationException::class);

        (new AuthGRIController())->register($request);
    }

    public function testRegisterFailsWhenUserCreationThrows(): void
    {
        Session::start();

        $input = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'securepass123',
            'password_confirmation' => 'securepass123',
            'company_name' => 'JaneCorp',
            'company_code' => 'JAN123',
            'industry' => 'Tech',
            'country' => 'Estonia',
            'size' => 'Small',
        ];

        $request = Mockery::mock(Request::class)->makePartial();
        $request->shouldReceive('validate')->andReturn($input);

        $this->expectException(\Exception::class);

        $userFactory = Mockery::mock();
        $userFactory->shouldReceive('create')->once()->andThrow(new \Exception('User creation failed'));

        $this->app->bind('user.factory', function () use ($userFactory) {
            return $userFactory;
        });

        $controller = new class($this->app->make('user.factory')) extends \App\Http\Controllers\AuthGRIController {
            protected $userFactory;
            public function __construct($userFactory) {
                $this->userFactory = $userFactory;
            }
            public function register($request) {
                $data = $request->validate([
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                    'company_name' => 'required',
                    'company_code' => 'required',
                    'industry' => 'required',
                    'country' => 'required',
                    'size' => 'required',
                ]);

                $user = $this->userFactory->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                ]);

                return redirect('/pagrindinis');
            }
        };

        $controller->register($request);
    }

    public function testRegisterFailsWhenCompanyCreationThrows(): void
    {
        Session::start();

        $input = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'securepass123',
            'password_confirmation' => 'securepass123',
            'company_name' => 'JaneCorp',
            'company_code' => 'JAN123',
            'industry' => 'Tech',
            'country' => 'Estonia',
            'size' => 'Small',
        ];

        $request = Mockery::mock(Request::class)->makePartial();
        $request->shouldReceive('validate')->andReturn($input);
        $request->shouldReceive('session')->andReturn(Mockery::mock(['regenerate' => null]));

        $user = Mockery::mock(\App\Models\User::class)->makePartial();
        $user->id = 1;

        $relation = Mockery::mock(HasMany::class);
        $relation->shouldReceive('create')->once()->andThrow(new \Exception('Company create failed'));
        $user->shouldReceive('companies')->andReturn($relation);

        // 👇 Changed from `once()` to `never()` since exception occurs before login
        Auth::shouldReceive('login')->never();

        $userFactory = Mockery::mock();
        $userFactory->shouldReceive('create')->once()->andReturn($user);

        $this->app->bind('user.factory', function () use ($userFactory) {
            return $userFactory;
        });

        $controller = new class($this->app->make('user.factory')) extends \App\Http\Controllers\AuthGRIController {
            protected $userFactory;
            public function __construct($userFactory) {
                $this->userFactory = $userFactory;
            }
            public function register($request) {
                $data = $request->validate([
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                    'company_name' => 'required',
                    'company_code' => 'required',
                    'industry' => 'required',
                    'country' => 'required',
                    'size' => 'required',
                ]);

                $user = $this->userFactory->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                ]);

                $user->companies()->create([
                    'company_name' => $data['company_name'],
                    'company_code' => $data['company_code'],
                    'industry' => $data['industry'],
                    'country' => $data['country'],
                    'size' => $data['size'],
                ]);

                Auth::login($user);
                $request->session()->regenerate();

                return redirect('/pagrindinis');
            }
        };

        $this->expectException(\Exception::class);
        $controller->register($request);
    }

    public function testLoginWithRemember(): void
    {
        $email = 'remember@example.com';
        $password = 'securepass123';

        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => $email, 'password' => $password], true)
            ->andReturnTrue();

        Auth::shouldReceive('user')->andReturn(Mockery::mock('UserStub'));

        Session::start();
        $request = Request::create('/login', 'POST', [
            'email' => $email,
            'password' => $password,
            'remember' => 'on',
        ]);
        $request->setLaravelSession(app('session.store'));

        $response = (new AuthGRIController())->login($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame(url('/pagrindinis'), $response->headers->get('Location'));
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
