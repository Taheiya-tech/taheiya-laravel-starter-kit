<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\UserPolicyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserPolicy\StoreManyUserPolicyRequest;
use App\Http\Requests\V1\UserPolicy\StoreUserPolicyRequest;
use App\Http\Requests\V1\UserPolicy\UpdateUserPolicyRequest;
use App\Models\User;
use App\Models\UserPolicy;
use App\Services\UserPolicyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class UserPolicyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public UserPolicyService $service)
    {
        $this->authorizeResource(UserPolicy::class);
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
    public function store(StoreUserPolicyRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new UserPolicyDto($request))
        );
    }

    /**
     * Display the specified UserPolicy.
     */
    public function show(UserPolicy $userPolicy): JsonResponse
    {
        return $this->ok($this->service->show($userPolicy));
    }

    /**
     * Update the specified UserPolicy in storage.
     */
    public function update(UpdateUserPolicyRequest $request, UserPolicy $userPolicy): JsonResponse
    {
        $userPolicy = $this->service
            ->update($userPolicy, new UserPolicyDto($request)
            );

        return $this->ok(data: $userPolicy, message: 'UserPolicy has been updated.');
    }

    /**
     * Remove the specified UserPolicy from storage.
     */
    public function destroy(UserPolicy $userPolicy): JsonResponse
    {
        if (! $this->service->delete($userPolicy)) {
            return $this->badRequest(message: 'UserPolicy has not been deleted.');
        }

        return $this->ok(message: 'UserPolicy has been deleted.');
    }

    public function saveMany(User $user, StoreManyUserPolicyRequest $request): JsonResponse
    {
        if (! $this->service->saveMany($request)) {
            return $this->badRequest(message: 'issue in saving many user policies.');
        }

        return $this->ok(message: 'all policies have been saved.');

    }
}
