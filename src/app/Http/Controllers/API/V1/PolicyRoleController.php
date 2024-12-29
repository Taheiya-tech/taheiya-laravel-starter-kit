<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\PolicyRoleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PolicyRole\StoreManyPolicyRoleRequest;
use App\Http\Requests\V1\PolicyRole\StorePolicyRoleRequest;
use App\Http\Requests\V1\PolicyRole\UpdatePolicyRoleRequest;
use App\Models\PolicyRole;
use App\Services\PolicyRoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PolicyRoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public PolicyRoleService $service)
    {
        $this->authorizeResource(PolicyRole::class);
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
    public function store(StorePolicyRoleRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new PolicyRoleDto($request))
        );
    }

    /**
     * Display the specified PolicyRole.
     */
    public function show(PolicyRole $policyRole): JsonResponse
    {
        return $this->ok($this->service->show($policyRole));
    }

    /**
     * Update the specified PolicyRole in storage.
     */
    public function update(UpdatePolicyRoleRequest $request, PolicyRole $policyRole): JsonResponse
    {
        $policyRole = $this->service
            ->update($policyRole, new PolicyRoleDto($request)
            );

        return $this->ok(data: $policyRole, message: 'PolicyRole has been updated.');
    }

    /**
     * Remove the specified PolicyRole from storage.
     */
    public function destroy(PolicyRole $policyRole): JsonResponse
    {
        if (! $this->service->delete($policyRole)) {
            return $this->badRequest(message: 'PolicyRole has not been deleted.');
        }

        return $this->ok(message: 'PolicyRole has been deleted.');
    }

    public function saveMany(int $roleId, StoreManyPolicyRoleRequest $request): JsonResponse
    {
        if (! $this->service->saveMany($request)) {
            return $this->badRequest(message: 'issue in saving many role policies.');
        }

        return $this->ok(message: 'all roles have been saved.');

    }
}
