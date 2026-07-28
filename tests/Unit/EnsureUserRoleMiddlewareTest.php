<?php

namespace Tests\Unit;

use App\Http\Middleware\EnsureUserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EnsureUserRoleMiddlewareTest extends TestCase
{
    /**
     * Skenario Positif (Happy Path):
     * Menguji bahwa middleware meneruskan request ($next) ketika pengguna terautentikasi dan memiliki role yang sesuai.
     */
    public function test_middleware_allows_request_when_user_has_matching_role()
    {
        // Mock user dengan role ADMIN
        $user = new User(['roles' => 'ADMIN']);
        Auth::shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($user);

        $middleware = new EnsureUserRole();
        $request = Request::create('/admin/dashboard', 'GET');

        // Callback next mengembalikan response 200 OK jika lolos verifikasi
        $response = $middleware->handle($request, function ($req) {
            return response('OK', 200);
        }, 'ADMIN');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }

    /**
     * Skenario Negatif / Edge Case 1:
     * Menguji bahwa middleware mengalihkan (redirect) ke '/' jika pengguna belum terautentikasi (guest).
     */
    public function test_middleware_redirects_when_user_is_not_authenticated()
    {
        Auth::shouldReceive('check')->once()->andReturn(false);

        $middleware = new EnsureUserRole();
        $request = Request::create('/admin/dashboard', 'GET');

        $response = $middleware->handle($request, function () {}, 'ADMIN');

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/'), $response->getTargetUrl());
    }

    /**
     * Skenario Negatif / Edge Case 2:
     * Menguji bahwa middleware mengalihkan (redirect) ke '/' jika role pengguna tidak cocok dengan parameter yang diminta.
     */
    public function test_middleware_redirects_when_user_role_mismatches()
    {
        // Mock user dengan role STUDENT mencoba mengakses route ADMIN
        $user = new User(['roles' => 'STUDENT']);
        Auth::shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($user);

        $middleware = new EnsureUserRole();
        $request = Request::create('/admin/dashboard', 'GET');

        $response = $middleware->handle($request, function () {}, 'ADMIN');

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/'), $response->getTargetUrl());
    }
}
