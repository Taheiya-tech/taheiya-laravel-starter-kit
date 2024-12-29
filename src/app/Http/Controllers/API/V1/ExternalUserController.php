<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ExternalUserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExternalUser\StoreExternalUserRequest;
use App\Http\Requests\V1\ExternalUser\UpdateExternalUserRequest;
use App\Models\ExternalUser;
use App\Services\ExternalUserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ExternalUserController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ExternalUserService $service)
    {
        $this->authorizeResource(ExternalUser::class);
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
    public function store(StoreExternalUserRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ExternalUserDto($request))
        );
    }

    /**
     * Display the specified ExternalUser.
     */
    public function show(ExternalUser $externalUser): JsonResponse
    {
        return $this->ok($this->service->show($externalUser));
    }

    /**
     * Update the specified ExternalUser in storage.
     */
    public function update(UpdateExternalUserRequest $request, ExternalUser $externalUser): JsonResponse
    {
        $externalUser = $this->service
            ->update($externalUser, new ExternalUserDto($request)
            );

        return $this->ok(data: $externalUser, message: 'ExternalUser has been updated.');
    }

    /**
     * Remove the specified ExternalUser from storage.
     */
    public function destroy(ExternalUser $externalUser): JsonResponse
    {
        if (! $this->service->delete($externalUser)) {
            return $this->badRequest(message: 'ExternalUser has not been deleted.');
        }

        return $this->ok(message: 'ExternalUser has been deleted.');
    }
}
