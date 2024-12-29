<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(public AuthService $service) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->service->logout($request);
            return $this->ok();
        } catch (ModelNotFoundException $exception) {
            return $this->notFound(message: $exception->getMessage());
        } catch (\Exception $e) {
            return $this->internalServerError(message: $e->getMessage());
        }

    }

}
