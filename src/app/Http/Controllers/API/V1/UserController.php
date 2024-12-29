<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\StoreUserRequest;
use App\Http\Requests\V1\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public UserService $service)
    {
        $this->authorizeResource(User::class);
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
    public function store(StoreUserRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new UserDto($request))
        );
    }

    /**
     * Display the specified User.
     */
    public function show(User $user): JsonResponse
    {
        return $this->ok($this->service->show($user));
    }

    /**
     * Update the specified User in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->service
            ->update($user, new UserDto($request)
            );

        return $this->ok(data: $user, message: 'User has been updated.');
    }

    /**
     * Remove the specified User from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        if (! $this->service->delete($user)) {
            return $this->badRequest(message: 'User has not been deleted.');
        }

        return $this->ok(message: 'User has been deleted.');
    }
}
