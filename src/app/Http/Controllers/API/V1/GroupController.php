<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\GroupDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Group\StoreGroupRequest;
use App\Http\Requests\V1\Group\UpdateGroupRequest;
use App\Models\Group;
use App\Services\GroupService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class GroupController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public GroupService $service)
    {
        $this->authorizeResource(Group::class);
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
    public function store(StoreGroupRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new GroupDto($request))
        );
    }

    /**
     * Display the specified Group.
     */
    public function show(Group $group): JsonResponse
    {
        return $this->ok($this->service->show($group));
    }

    /**
     * Update the specified Group in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group): JsonResponse
    {
        $group = $this->service
            ->update($group, new GroupDto($request)
            );

        return $this->ok(data: $group, message: 'Group has been updated.');
    }

    /**
     * Remove the specified Group from storage.
     */
    public function destroy(Group $group): JsonResponse
    {
        if (! $this->service->delete($group)) {
            return $this->badRequest(message: 'Group has not been deleted.');
        }

        return $this->ok(message: 'Group has been deleted.');
    }
}
