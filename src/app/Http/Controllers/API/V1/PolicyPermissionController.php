<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\PolicyPermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManyPolicyPermissionRequest;
use App\Http\Requests\V1\PolicyPermission\StorePolicyPermissionRequest;
use App\Http\Requests\V1\PolicyPermission\UpdatePolicyPermissionRequest;
use App\Models\PolicyPermission;
use App\Services\PolicyPermissionService;
use Illuminate\Http\JsonResponse;

class PolicyPermissionController extends Controller
{
    public function __construct(public PolicyPermissionService $service) {}

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
    public function store(StorePolicyPermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new PolicyPermissionDto($request))
        );
    }

    /**
     * Display the specified PolicyPermission.
     */
    public function show(PolicyPermission $policyPermission): JsonResponse
    {
        return $this->ok($this->service->show($policyPermission));
    }

    /**
     * Update the specified PolicyPermission in storage.
     */
    public function update(UpdatePolicyPermissionRequest $request, PolicyPermission $policyPermission): JsonResponse
    {
        $policyPermission = $this->service
            ->update($policyPermission, new PolicyPermissionDto($request)
            );

        return $this->ok(data: $policyPermission, message: 'PolicyPermission has been updated.');
    }

    /**
     * Remove the specified PolicyPermission from storage.
     */
    public function destroy(PolicyPermission $policyPermission): JsonResponse
    {
        if (! $this->service->delete($policyPermission)) {
            return $this->badRequest(message: 'PolicyPermission has not been deleted.');
        }

        return $this->ok(message: 'PolicyPermission has been deleted.');
    }

    public function saveMany(int $policy, StoreManyPolicyPermissionRequest $request): JsonResponse
    {
        if (! $this->service->saveMany($request)) {
            return $this->badRequest(message: 'issue in saving many user policies.');
        }

        return $this->ok(message: 'all policies have been saved.');

    }
}
