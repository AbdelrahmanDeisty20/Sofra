<?php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

use App\Exceptions\Handler;
class Kernel extends HttpKernel
{
    protected $handlers = [
        'exception' => Handler::class,
    ];
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        // 'autoCheckPermission' => Middleware\AutoCheckPermission::class,
    ]
;
    // ...
}
