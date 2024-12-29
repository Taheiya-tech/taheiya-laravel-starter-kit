<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ExternalUserPolicyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExternalUserPolicy\StoreExternalUserPolicyRequest;
use App\Http\Requests\V1\ExternalUserPolicy\UpdateExternalUserPolicyRequest;
use App\Models\ExternalUserPolicy;
use App\Services\ExternalUserPolicyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ExternalUserPolicyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ExternalUserPolicyService $service)
    {
        $this->authorizeResource(ExternalUserPolicy::class);
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
    public function store(StoreExternalUserPolicyRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ExternalUserPolicyDto($request))
        );
    }

    /**
     * Display the specified ExternalUserPolicy.
     */
    public function show(ExternalUserPolicy $externalUserPolicy): JsonResponse
    {
        return $this->ok($this->service->show($externalUserPolicy));
    }

    /**
     * Update the specified ExternalUserPolicy in storage.
     */
    public function update(UpdateExternalUserPolicyRequest $request, ExternalUserPolicy $externalUserPolicy): JsonResponse
    {
        $externalUserPolicy = $this->service
            ->update($externalUserPolicy, new ExternalUserPolicyDto($request)
            );

        return $this->ok(data: $externalUserPolicy, message: 'ExternalUserPolicy has been updated.');
    }

    /**
     * Remove the specified ExternalUserPolicy from storage.
     */
    public function destroy(ExternalUserPolicy $externalUserPolicy): JsonResponse
    {
        if (! $this->service->delete($externalUserPolicy)) {
            return $this->badRequest(message: 'ExternalUserPolicy has not been deleted.');
        }

        return $this->ok(message: 'ExternalUserPolicy has been deleted.');
    }
}
