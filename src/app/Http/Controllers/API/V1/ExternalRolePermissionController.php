<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ExternalRolePermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExternalRolePermission\StoreExternalRolePermissionRequest;
use App\Http\Requests\V1\ExternalRolePermission\UpdateExternalRolePermissionRequest;
use App\Models\ExternalRolePermission;
use App\Services\ExternalRolePermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ExternalRolePermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ExternalRolePermissionService $service)
    {
        $this->authorizeResource(ExternalRolePermission::class);
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
    public function store(StoreExternalRolePermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ExternalRolePermissionDto($request))
        );
    }

    /**
     * Display the specified ExternalRolePermission.
     */
    public function show(ExternalRolePermission $externalRolePermission): JsonResponse
    {
        return $this->ok($this->service->show($externalRolePermission));
    }

    /**
     * Update the specified ExternalRolePermission in storage.
     */
    public function update(UpdateExternalRolePermissionRequest $request, ExternalRolePermission $externalRolePermission): JsonResponse
    {
        $externalRolePermission = $this->service
            ->update($externalRolePermission, new ExternalRolePermissionDto($request)
            );

        return $this->ok(data: $externalRolePermission, message: 'ExternalRolePermission has been updated.');
    }

    /**
     * Remove the specified ExternalRolePermission from storage.
     */
    public function destroy(ExternalRolePermission $externalRolePermission): JsonResponse
    {
        if (! $this->service->delete($externalRolePermission)) {
            return $this->badRequest(message: 'ExternalRolePermission has not been deleted.');
        }

        return $this->ok(message: 'ExternalRolePermission has been deleted.');
    }
}
