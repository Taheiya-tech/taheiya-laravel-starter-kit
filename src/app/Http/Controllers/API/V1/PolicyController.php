<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\PolicyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Policy\StorePolicyRequest;
use App\Http\Requests\V1\Policy\UpdatePolicyRequest;
use App\Models\Policy;
use App\Services\PolicyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PolicyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public PolicyService $service)
    {
        $this->authorizeResource(Policy::class);
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
    public function store(StorePolicyRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new PolicyDto($request))
        );
    }

    /**
     * Display the specified Policy.
     */
    public function show(Policy $policy): JsonResponse
    {
        return $this->ok($this->service->show($policy));
    }

    /**
     * Update the specified Policy in storage.
     */
    public function update(UpdatePolicyRequest $request, Policy $policy): JsonResponse
    {
        $policy = $this->service
            ->update($policy, new PolicyDto($request)
            );

        return $this->ok(data: $policy, message: 'Policy has been updated.');
    }

    /**
     * Remove the specified Policy from storage.
     */
    public function destroy(Policy $policy): JsonResponse
    {
        if (! $this->service->delete($policy)) {
            return $this->badRequest(message: 'Policy has not been deleted.');
        }

        return $this->ok(message: 'Policy has been deleted.');
    }
}
