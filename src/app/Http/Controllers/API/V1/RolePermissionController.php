<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\RolePermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RolePermission\StoreRolePermissionRequest;
use App\Http\Requests\V1\RolePermission\UpdateRolePermissionRequest;
use App\Models\RolePermission;
use App\Services\RolePermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class RolePermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public RolePermissionService $service)
    {
        $this->authorizeResource(RolePermission::class);
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
    public function store(StoreRolePermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new RolePermissionDto($request))
        );
    }

    /**
     * Display the specified RolePermission.
     */
    public function show(RolePermission $rolePermission): JsonResponse
    {
        return $this->ok($this->service->show($rolePermission));
    }

    /**
     * Update the specified RolePermission in storage.
     */
    public function update(UpdateRolePermissionRequest $request, RolePermission $rolePermission): JsonResponse
    {
        $rolePermission = $this->service
            ->update($rolePermission, new RolePermissionDto($request)
            );

        return $this->ok(data: $rolePermission, message: 'RolePermission has been updated.');
    }

    /**
     * Remove the specified RolePermission from storage.
     */
    public function destroy(RolePermission $rolePermission): JsonResponse
    {
        if (! $this->service->delete($rolePermission)) {
            return $this->badRequest(message: 'RolePermission has not been deleted.');
        }
        $this->service->delete($rolePermission);

        return $this->ok(message: 'RolePermission has been deleted.');
    }
}
