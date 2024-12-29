<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\PolicyConditionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PolicyCondition\StorePolicyConditionRequest;
use App\Http\Requests\V1\PolicyCondition\UpdatePolicyConditionRequest;
use App\Models\PolicyCondition;
use App\Services\PolicyConditionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PolicyConditionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public PolicyConditionService $service)
    {
        $this->authorizeResource(PolicyCondition::class);
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
    public function store(StorePolicyConditionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new PolicyConditionDto($request))
        );
    }

    /**
     * Display the specified PolicyCondition.
     */
    public function show(PolicyCondition $policyCondition): JsonResponse
    {
        return $this->ok($this->service->show($policyCondition));
    }

    /**
     * Update the specified PolicyCondition in storage.
     */
    public function update(UpdatePolicyConditionRequest $request, PolicyCondition $policyCondition): JsonResponse
    {
        $policyCondition = $this->service
            ->update($policyCondition, new PolicyConditionDto($request)
            );

        return $this->ok(data: $policyCondition, message: 'PolicyCondition has been updated.');
    }

    /**
     * Remove the specified PolicyCondition from storage.
     */
    public function destroy(PolicyCondition $policyCondition): JsonResponse
    {
        if (! $this->service->delete($policyCondition)) {
            return $this->badRequest(message: 'PolicyCondition has not been deleted.');
        }

        return $this->ok(message: 'PolicyCondition has been deleted.');
    }
}
