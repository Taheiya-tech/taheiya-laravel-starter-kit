<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\GroupPermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GroupPermission\StoreGroupPermissionRequest;
use App\Http\Requests\V1\GroupPermission\UpdateGroupPermissionRequest;
use App\Models\GroupPermission;
use App\Services\GroupPermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class GroupPermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public GroupPermissionService $service)
    {
        $this->authorizeResource(GroupPermission::class);
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
    public function store(StoreGroupPermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new GroupPermissionDto($request))
        );
    }

    /**
     * Display the specified GroupPermission.
     */
    public function show(GroupPermission $groupPermission): JsonResponse
    {
        return $this->ok($this->service->show($groupPermission));
    }

    /**
     * Update the specified GroupPermission in storage.
     */
    public function update(UpdateGroupPermissionRequest $request, GroupPermission $groupPermission): JsonResponse
    {
        $groupPermission = $this->service
            ->update($groupPermission, new GroupPermissionDto($request)
            );

        return $this->ok(data: $groupPermission, message: 'GroupPermission has been updated.');
    }

    /**
     * Remove the specified GroupPermission from storage.
     */
    public function destroy(GroupPermission $groupPermission): JsonResponse
    {
        if (! $this->service->delete($groupPermission)) {
            return $this->badRequest(message: 'GroupPermission has not been deleted.');
        }

        return $this->ok(message: 'GroupPermission has been deleted.');
    }
}
