<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\GroupRoleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GroupRole\StoreGroupRoleRequest;
use App\Http\Requests\V1\GroupRole\UpdateGroupRoleRequest;
use App\Models\GroupRole;
use App\Services\GroupRoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class GroupRoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public GroupRoleService $service)
    {
        $this->authorizeResource(GroupRole::class);
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
    public function store(StoreGroupRoleRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new GroupRoleDto($request))
        );
    }

    /**
     * Display the specified GroupRole.
     */
    public function show(GroupRole $groupRole): JsonResponse
    {
        return $this->ok($this->service->show($groupRole));
    }

    /**
     * Update the specified GroupRole in storage.
     */
    public function update(UpdateGroupRoleRequest $request, GroupRole $groupRole): JsonResponse
    {
        $groupRole = $this->service
            ->update($groupRole, new GroupRoleDto($request)
            );

        return $this->ok(data: $groupRole, message: 'GroupRole has been updated.');
    }

    /**
     * Remove the specified GroupRole from storage.
     */
    public function destroy(GroupRole $groupRole): JsonResponse
    {
        if (! $this->service->delete($groupRole)) {
            return $this->badRequest(message: 'GroupRole has not been deleted.');
        }

        return $this->ok(message: 'GroupRole has been deleted.');
    }
}
