<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'is.authenticate.admin' => \App\Http\Middleware\Admin\IsAuthenticate::class,
        'is.root.admin' => \App\Http\Middleware\Admin\IsRoot::class,
        'is.master.admin' => \App\Http\Middleware\Admin\IsMaster::class,
        'jwt.verifytoken' => \App\Http\Middleware\Admin\VerifyJWTToken::class,
        'paginator.admin' => \App\Http\Middleware\Admin\Paginator::class,
        'parameters.admin' => \App\Http\Middleware\Admin\Parameters::class,
        'parameters-admin.admin' => \App\Http\Middleware\Admin\ParametersAdmin::class,
        'parameters-public.admin' => \App\Http\Middleware\Admin\ParametersPublic::class,
        'parameters-products.admin' => \App\Http\Middleware\Admin\ParametersProducts::class,
        'parameters-products-image.admin' => \App\Http\Middleware\Admin\ParametersProductsImages::class,
        'parameters-sharestypes.admin' => \App\Http\Middleware\Admin\ParametersSharesTypes::class,
        'parameters-orders.admin' => \App\Http\Middleware\Admin\ParametersOrders::class,
        'parameters-orders-upc.admin' => \App\Http\Middleware\Admin\ParametersOrdersUpc::class,
        'parameters-orders-udc.admin' => \App\Http\Middleware\Admin\ParametersOrdersUdc::class,
        'parameters-orders-udc-public.admin' => \App\Http\Middleware\Admin\ParametersOrdersUdcPublic::class,
        'parameters-customers.admin' => \App\Http\Middleware\Admin\ParametersCustomers::class
    ];
}
