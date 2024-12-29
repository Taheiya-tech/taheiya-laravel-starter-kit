<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\GroupPolicyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GroupPolicy\StoreGroupPolicyRequest;
use App\Http\Requests\V1\GroupPolicy\StoreManyGroupPolicyRequest;
use App\Http\Requests\V1\GroupPolicy\UpdateGroupPolicyRequest;
use App\Models\GroupPolicy;
use App\Services\GroupPolicyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class GroupPolicyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public GroupPolicyService $service)
    {
        $this->authorizeResource(GroupPolicy::class);
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
    public function store(StoreGroupPolicyRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new GroupPolicyDto($request))
        );
    }

    /**
     * Display the specified GroupPolicy.
     */
    public function show(GroupPolicy $groupPolicy): JsonResponse
    {
        return $this->ok($this->service->show($groupPolicy));
    }

    /**
     * Update the specified GroupPolicy in storage.
     */
    public function update(UpdateGroupPolicyRequest $request, GroupPolicy $groupPolicy): JsonResponse
    {
        $groupPolicy = $this->service
            ->update($groupPolicy, new GroupPolicyDto($request)
            );

        return $this->ok(data: $groupPolicy, message: 'GroupPolicy has been updated.');
    }

    /**
     * Remove the specified GroupPolicy from storage.
     */
    public function destroy(GroupPolicy $groupPolicy): JsonResponse
    {
        if (! $this->service->delete($groupPolicy)) {
            return $this->badRequest(message: 'GroupPolicy has not been deleted.');
        }

        return $this->ok(message: 'GroupPolicy has been deleted.');
    }

    public function saveMany(int $groupId, StoreManyGroupPolicyRequest $request): JsonResponse
    {
        if (! $this->service->saveMany($request)) {
            return $this->badRequest(message: 'issue in saving many role policies.');
        }

        return $this->ok(message: 'all policies have been saved.');

    }
}
