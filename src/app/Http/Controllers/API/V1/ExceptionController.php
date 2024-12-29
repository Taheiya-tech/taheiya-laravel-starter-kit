<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ExceptionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Exception\StoreExceptionRequest;
use App\Http\Requests\V1\Exception\UpdateExceptionRequest;
use App\Models\Exception;
use App\Services\ExceptionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ExceptionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ExceptionService $service)
    {
        $this->authorizeResource(Exception::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->ok($this->service->getAll(request: request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExceptionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ExceptionDto($request))
        );
    }

    /**
     * Display the specified Exception.
     */
    public function show(Exception $exception): JsonResponse
    {
        return $this->ok($this->service->show($exception));
    }

    /**
     * Update the specified Exception in storage.
     */
    public function update(UpdateExceptionRequest $request, Exception $exception): JsonResponse
    {
        $exception = $this->service
            ->update($exception, new ExceptionDto($request)
            );

        return $this->ok(data: $exception, message: 'Exception has been updated.');
    }

    /**
     * Remove the specified Exception from storage.
     */
    public function destroy(Exception $exception): JsonResponse
    {
        if (! $this->service->delete($exception)) {
            return $this->badRequest(message: 'Exception has not been deleted.');
        }

        return $this->ok(message: 'Exception has been deleted.');
    }
}
