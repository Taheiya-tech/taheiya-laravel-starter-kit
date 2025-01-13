<?php

use TaheiyaTech\TaheiyaLaravelStarterKit\App\Http\Controllers\API\BaseController;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //        $middleware->append(ApiKey::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                $message = $e->getMessage();
                $errors = $e->errors();
                $data = [];

                return app(BaseController::class)->badRequest(data: $data, message: $message, errors: $errors);
            }

            return false;
        });

        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                $message = $e->getMessage();
                $errors = [];
                $data = [];

                return app(BaseController::class)->badRequest(data: $data, message: $message, errors: $errors);
            }

            return false;
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                $message = 'Resource not found';
                $errors = [];
                $data = [];

                Log::error($message);

                return app(BaseController::class)->badRequest(data: $data, message: $message, errors: $errors);
            }

            return false;
        });

        $exceptions->render(function (AuthorizationException|AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                $message = 'User is not authorized';
                $errors = [];
                $data = [];

                Log::error($message);

                return app(BaseController::class)->forbidden(data: $data, message: $message, errors: $errors);
            }

            return false;
        });

        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                $message = 'User is not authenticated';
                $errors = [];
                $data = [];

                Log::error($message);

                return app(BaseController::class)->unauthorized(data: $data, message: $message, errors: $errors);
            }

            return false;
        });

        $exceptions->render(function (Error $e, $request) {
            if ($request->is('api/*')) {
                $message = 'Server error Found Try Again Later';
                $errors = [];
                $data = [];

                if (config('app.debug')) {
                    $errors = [$e->getMessage()];
                }

                return app(BaseController::class)->internalServerError(data: $data, message: $message, errors: $errors);
            }

            return false;
        });

        $exceptions->render(function (Exception $e, $request) {
            if ($request->is('api/*')) {
                $message = 'Server error Found Try Again Later';
                $errors = [];
                $data = [];

                if (config('app.debug')) {
                    $errors = [$e->getMessage()];
                }

                return app(BaseController::class)->internalServerError(data: $data, message: $message, errors: $errors);
            }

            return false;
        });

    })->create();
