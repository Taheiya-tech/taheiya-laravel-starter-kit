<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\BoundaryPermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BoundaryPermission\StoreBoundaryPermissionRequest;
use App\Http\Requests\V1\BoundaryPermission\UpdateBoundaryPermissionRequest;
use App\Models\BoundaryPermission;
use App\Services\BoundaryPermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class BoundaryPermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public BoundaryPermissionService $service)
    {
        $this->authorizeResource(BoundaryPermission::class);
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
    public function store(StoreBoundaryPermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new BoundaryPermissionDto($request))
        );
    }

    /**
     * Display the specified BoundaryPermission.
     */
    public function show(BoundaryPermission $boundaryPermission): JsonResponse
    {
        return $this->ok($this->service->show($boundaryPermission));
    }

    /**
     * Update the specified BoundaryPermission in storage.
     */
    public function update(UpdateBoundaryPermissionRequest $request, BoundaryPermission $boundaryPermission): JsonResponse
    {
        $boundaryPermission = $this->service
            ->update($boundaryPermission, new BoundaryPermissionDto($request)
            );

        return $this->ok(data: $boundaryPermission, message: 'BoundaryPermission has been updated.');
    }

    /**
     * Remove the specified BoundaryPermission from storage.
     */
    public function destroy(BoundaryPermission $boundaryPermission): JsonResponse
    {
        if (! $this->service->delete($boundaryPermission)) {
            return $this->badRequest(message: 'BoundaryPermission has not been deleted.');
        }

        return $this->ok(message: 'BoundaryPermission has been deleted.');
    }
}
