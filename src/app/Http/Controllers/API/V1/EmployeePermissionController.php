<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\EmployeePermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EmployeePermission\StoreEmployeePermissionRequest;
use App\Http\Requests\V1\EmployeePermission\UpdateEmployeePermissionRequest;
use App\Models\EmployeePermission;
use App\Services\EmployeePermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class EmployeePermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public EmployeePermissionService $service)
    {
        $this->authorizeResource(EmployeePermission::class);
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
    public function store(StoreEmployeePermissionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new EmployeePermissionDto($request))
        );
    }

    /**
     * Display the specified EmployeePermission.
     */
    public function show(EmployeePermission $employeePermission): JsonResponse
    {
        return $this->ok($this->service->show($employeePermission));
    }

    /**
     * Update the specified EmployeePermission in storage.
     */
    public function update(UpdateEmployeePermissionRequest $request, EmployeePermission $employeePermission): JsonResponse
    {
        $employeePermission = $this->service
            ->update($employeePermission, new EmployeePermissionDto($request)
            );

        return $this->ok(data: $employeePermission, message: 'EmployeePermission has been updated.');
    }

    /**
     * Remove the specified EmployeePermission from storage.
     */
    public function destroy(EmployeePermission $employeePermission): JsonResponse
    {
        if (! $this->service->delete($employeePermission)) {
            return $this->badRequest(message: 'EmployeePermission has not been deleted.');
        }

        return $this->ok(message: 'EmployeePermission has been deleted.');
    }
}
