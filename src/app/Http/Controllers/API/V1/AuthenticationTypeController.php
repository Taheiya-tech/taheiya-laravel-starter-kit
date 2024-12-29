<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AuthenticationType\StoreAuthenticationTypeRequest;
use App\Http\Requests\V1\AuthenticationType\UpdateAuthenticationTypeRequest;
use App\Http\Resources\V1\AuthenticationTypeCollection;
use App\Http\Resources\V1\AuthenticationTypeResource;
use App\Models\AuthenticationType;
use App\Services\AuthenticationTypeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class AuthenticationTypeController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public AuthenticationTypeService $service)
    {
        $this->authorizeResource(AuthenticationType::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $authenticationTypes = new AuthenticationTypeCollection(AuthenticationType::paginate(request()->integer('perPage', 10)));

        return $this->ok($authenticationTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthenticationTypeRequest $request): JsonResponse
    {
        $authenticationType = new AuthenticationTypeResource(AuthenticationType::create($request->validated()));

        return $this->created(data: $authenticationType, message: 'Authentication has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthenticationType $authenticationType): JsonResponse
    {
        return $this->ok(new AuthenticationTypeResource($authenticationType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthenticationTypeRequest $request, AuthenticationType $authenticationType): JsonResponse
    {
        $authenticationType->update($request->validated());

        return $this->ok(data: new AuthenticationTypeResource($authenticationType), message: 'Authentication type has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthenticationType $authenticationType): JsonResponse
    {
        if (! $this->service->delete($authenticationType)) {
            return $this->badRequest(message: 'Authentication type has not been deleted.');
        }

        return $this->ok(message: 'Authentication type has been deleted.');
    }
}
