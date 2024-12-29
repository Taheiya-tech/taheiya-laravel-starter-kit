<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\EmployeeRoleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EmployeeRole\StoreEmployeeRoleRequest;
use App\Http\Requests\V1\EmployeeRole\UpdateEmployeeRoleRequest;
use App\Models\EmployeeRole;
use App\Services\EmployeeRoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class EmployeeRoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public EmployeeRoleService $service)
    {
        $this->authorizeResource(EmployeeRole::class);
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
    public function store(StoreEmployeeRoleRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new EmployeeRoleDto($request))
        );
    }

    /**
     * Display the specified EmployeeRole.
     */
    public function show(EmployeeRole $employeeRole): JsonResponse
    {
        return $this->ok($this->service->show($employeeRole));
    }

    /**
     * Update the specified EmployeeRole in storage.
     */
    public function update(UpdateEmployeeRoleRequest $request, EmployeeRole $employeeRole): JsonResponse
    {
        $employeeRole = $this->service
            ->update($employeeRole, new EmployeeRoleDto($request)
            );

        return $this->ok(data: $employeeRole, message: 'EmployeeRole has been updated.');
    }

    /**
     * Remove the specified EmployeeRole from storage.
     */
    public function destroy(EmployeeRole $employeeRole): JsonResponse
    {
        if (! $this->service->delete($employeeRole)) {
            return $this->badRequest(message: 'EmployeeRole has not been deleted.');
        }

        return $this->ok(message: 'EmployeeRole has been deleted.');
    }
}
