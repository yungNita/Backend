<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RoleMiddleware;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'api' => [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        // 'auth' => Authenticate::class,
        'role' => RoleMiddleware::class, 
    ];
}
