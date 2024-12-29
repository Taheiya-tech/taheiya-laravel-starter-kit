<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\UserRoleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserRole\StoreUserRoleRequest;
use App\Http\Requests\V1\UserRole\UpdateUserRoleRequest;
use App\Models\UserRole;
use App\Services\UserRoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class UserRoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public UserRoleService $service)
    {
        $this->authorizeResource(UserRole::class);
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
    public function store(StoreUserRoleRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new UserRoleDto($request))
        );
    }

    /**
     * Display the specified UserRole.
     */
    public function show(UserRole $userRole): JsonResponse
    {
        return $this->ok($this->service->show($userRole));
    }

    /**
     * Update the specified UserRole in storage.
     */
    public function update(UpdateUserRoleRequest $request, UserRole $userRole): JsonResponse
    {
        $userRole = $this->service
            ->update($userRole, new UserRoleDto($request)
            );

        return $this->ok(data: $userRole, message: 'UserRole has been updated.');
    }

    /**
     * Remove the specified UserRole from storage.
     */
    public function destroy(UserRole $userRole): JsonResponse
    {
        if (! $this->service->delete($userRole)) {
            return $this->badRequest(message: 'UserRole has not been deleted.');
        }

        return $this->ok(message: 'UserRole has been deleted.');
    }
}
