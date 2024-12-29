<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\PermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Permission\StorePermissionRequest;
use App\Http\Requests\V1\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public PermissionService $service)
    {
        $this->authorizeResource(Permission::class);
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
    public function store(StorePermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new PermissionDto($request))
        );
    }

    /**
     * Display the specified Permission.
     */
    public function show(Permission $permission): JsonResponse
    {
        return $this->ok($this->service->show($permission));
    }

    /**
     * Update the specified Permission in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse
    {
        $permission = $this->service
            ->update($permission, new PermissionDto($request)
            );

        return $this->ok(data: $permission, message: 'Permission has been updated.');
    }

    /**
     * Remove the specified Permission from storage.
     */
    public function destroy(Permission $permission): JsonResponse
    {
        if (! $this->service->delete($permission)) {
            return $this->badRequest(message: 'Permission has not been deleted.');
        }

        return $this->ok(message: 'Permission has been deleted.');
    }
}
