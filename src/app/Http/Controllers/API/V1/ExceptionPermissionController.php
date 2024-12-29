<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ExceptionPermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExceptionPermission\StoreExceptionPermissionRequest;
use App\Http\Requests\V1\ExceptionPermission\UpdateExceptionPermissionRequest;
use App\Models\ExceptionPermission;
use App\Services\ExceptionPermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ExceptionPermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ExceptionPermissionService $service)
    {
        $this->authorizeResource(ExceptionPermission::class);
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
    public function store(StoreExceptionPermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ExceptionPermissionDto($request))
        );
    }

    /**
     * Display the specified ExceptionPermission.
     */
    public function show(ExceptionPermission $exceptionPermission): JsonResponse
    {
        return $this->ok($this->service->show($exceptionPermission));
    }

    /**
     * Update the specified ExceptionPermission in storage.
     */
    public function update(UpdateExceptionPermissionRequest $request, ExceptionPermission $exceptionPermission): JsonResponse
    {
        $exceptionPermission = $this->service
            ->update($exceptionPermission, new ExceptionPermissionDto($request)
            );

        return $this->ok(data: $exceptionPermission, message: 'ExceptionPermission has been updated.');
    }

    /**
     * Remove the specified ExceptionPermission from storage.
     */
    public function destroy(ExceptionPermission $exceptionPermission): JsonResponse
    {
        if (! $this->service->delete($exceptionPermission)) {
            return $this->badRequest(message: 'ExceptionPermission has not been deleted.');
        }

        return $this->ok(message: 'ExceptionPermission has been deleted.');
    }
}
