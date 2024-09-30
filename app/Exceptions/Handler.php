<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as BaseExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Throwable;

class Handler extends BaseExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, string>
     */
    protected $dontReport = [
        // Add exception types that should not be reported here
    ];

    /**
     * A list of the inputs that are never flashed for security reasons.
     *
     * @var array<string, string>
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling event listeners.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Add custom reporting logic here
        });
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                // Customize the message and status code for JSON requests
                return response()->json([
                    'essage' => 'You are not authorized to access this resource.', // Customize this message
                    'tatus_code' => 401,
                ], 401);
            }

            return redirect()->guest(route('login')); // Or your desired login route
        }

        return parent::render($request, $exception);
        // dd(1);
    }
}
