<?php

namespace App\Http\Controllers\API\V1\Auth\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(public AuthService $service) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            return $this->ok($this->service->login($request));
        } catch (ModelNotFoundException $exception) {
            return $this->notFound(message: $exception->getMessage());
        } catch (\Exception $e) {
            return $this->internalServerError(message: $e->getMessage());
        }

    }
}
