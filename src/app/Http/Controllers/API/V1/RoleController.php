<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\RoleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Role\StoreRoleRequest;
use App\Http\Requests\V1\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public RoleService $service)
    {
        $this->authorizeResource(Role::class);
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
    public function store(StoreRoleRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new RoleDto($request))
        );
    }

    /**
     * Display the specified Role.
     */
    public function show(Role $role): JsonResponse
    {
        return $this->ok($this->service->show($role));
    }

    /**
     * Update the specified Role in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $role = $this->service
            ->update($role, new RoleDto($request)
            );

        return $this->ok(data: $role, message: 'Role has been updated.');
    }

    /**
     * Remove the specified Role from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        if (! $this->service->delete($role)) {
            return $this->badRequest(message: 'Role has not been deleted.');
        }

        return $this->ok(message: 'Role has been deleted.');
    }
}
