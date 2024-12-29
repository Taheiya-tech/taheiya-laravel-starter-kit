<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\CompanyPlatformPermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CompanyPlatformPermission\StoreCompanyPlatformPermissionRequest;
use App\Http\Requests\V1\CompanyPlatformPermission\UpdateCompanyPlatformPermissionRequest;
use App\Models\CompanyPlatformPermission;
use App\Services\CompanyPlatformPermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class CompanyPlatformPermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public CompanyPlatformPermissionService $service)
    {
        $this->authorizeResource(CompanyPlatformPermission::class);
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
    public function store(StoreCompanyPlatformPermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new CompanyPlatformPermissionDto($request))
        );
    }

    /**
     * Display the specified CompanyPlatformPermission.
     */
    public function show(CompanyPlatformPermission $companyPlatformPermission): JsonResponse
    {
        return $this->ok($this->service->show($companyPlatformPermission));
    }

    /**
     * Update the specified CompanyPlatformPermission in storage.
     */
    public function update(UpdateCompanyPlatformPermissionRequest $request, CompanyPlatformPermission $companyPlatformPermission): JsonResponse
    {
        $companyPlatformPermission = $this->service
            ->update($companyPlatformPermission, new CompanyPlatformPermissionDto($request)
            );

        return $this->ok(data: $companyPlatformPermission, message: 'CompanyPlatformPermission has been updated.');
    }

    /**
     * Remove the specified CompanyPlatformPermission from storage.
     */
    public function destroy(CompanyPlatformPermission $companyPlatformPermission): JsonResponse
    {
        if (! $this->service->delete($companyPlatformPermission)) {
            return $this->badRequest(message: 'CompanyPlatformPermission has not been deleted.');
        }

        return $this->ok(message: 'CompanyPlatformPermission has been deleted.');
    }
}
