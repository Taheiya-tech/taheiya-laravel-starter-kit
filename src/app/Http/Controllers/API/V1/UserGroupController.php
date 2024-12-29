<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\UserGroupDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserGroup\StoreUserGroupRequest;
use App\Http\Requests\V1\UserGroup\UpdateUserGroupRequest;
use App\Models\UserGroup;
use App\Services\UserGroupService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class UserGroupController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public UserGroupService $service)
    {
        $this->authorizeResource(UserGroup::class);
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
    public function store(StoreUserGroupRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new UserGroupDto($request))
        );
    }

    /**
     * Display the specified UserGroup.
     */
    public function show(UserGroup $userGroup): JsonResponse
    {
        return $this->ok($this->service->show($userGroup));
    }

    /**
     * Update the specified UserGroup in storage.
     */
    public function update(UpdateUserGroupRequest $request, UserGroup $userGroup): JsonResponse
    {
        $userGroup = $this->service
            ->update($userGroup, new UserGroupDto($request)
            );

        return $this->ok(data: $userGroup, message: 'UserGroup has been updated.');
    }

    /**
     * Remove the specified UserGroup from storage.
     */
    public function destroy(UserGroup $userGroup): JsonResponse
    {
        if (! $this->service->delete($userGroup)) {
            return $this->badRequest(message: 'UserGroup has not been deleted.');
        }

        return $this->ok(message: 'UserGroup has been deleted.');
    }
}
