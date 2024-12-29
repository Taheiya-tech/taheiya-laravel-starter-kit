<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ExternalRoleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExternalRole\StoreExternalRoleRequest;
use App\Http\Requests\V1\ExternalRole\UpdateExternalRoleRequest;
use App\Models\ExternalRole;
use App\Services\ExternalRoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ExternalRoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ExternalRoleService $service)
    {
        $this->authorizeResource(ExternalRole::class);
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
    public function store(StoreExternalRoleRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ExternalRoleDto($request))
        );
    }

    /**
     * Display the specified ExternalRole.
     */
    public function show(ExternalRole $externalRole): JsonResponse
    {
        return $this->ok($this->service->show($externalRole));
    }

    /**
     * Update the specified ExternalRole in storage.
     */
    public function update(UpdateExternalRoleRequest $request, ExternalRole $externalRole): JsonResponse
    {
        $externalRole = $this->service
            ->update($externalRole, new ExternalRoleDto($request)
            );

        return $this->ok(data: $externalRole, message: 'ExternalRole has been updated.');
    }

    /**
     * Remove the specified ExternalRole from storage.
     */
    public function destroy(ExternalRole $externalRole): JsonResponse
    {
        if (! $this->service->delete($externalRole)) {
            return $this->badRequest(message: 'ExternalRole has not been deleted.');
        }

        return $this->ok(message: 'ExternalRole has been deleted.');
    }
}
