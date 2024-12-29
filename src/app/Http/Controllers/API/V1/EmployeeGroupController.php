<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\EmployeeGroupDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EmployeeGroup\StoreEmployeeGroupRequest;
use App\Http\Requests\V1\EmployeeGroup\UpdateEmployeeGroupRequest;
use App\Models\EmployeeGroup;
use App\Services\EmployeeGroupService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class EmployeeGroupController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public EmployeeGroupService $service)
    {
        $this->authorizeResource(EmployeeGroup::class);
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
    public function store(StoreEmployeeGroupRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new EmployeeGroupDto($request))
        );
    }

    /**
     * Display the specified EmployeeGroup.
     */
    public function show(EmployeeGroup $employeeGroup): JsonResponse
    {
        return $this->ok($this->service->show($employeeGroup));
    }

    /**
     * Update the specified EmployeeGroup in storage.
     */
    public function update(UpdateEmployeeGroupRequest $request, EmployeeGroup $employeeGroup): JsonResponse
    {
        $employeeGroup = $this->service
            ->update($employeeGroup, new EmployeeGroupDto($request)
            );

        return $this->ok(data: $employeeGroup, message: 'EmployeeGroup has been updated.');
    }

    /**
     * Remove the specified EmployeeGroup from storage.
     */
    public function destroy(EmployeeGroup $employeeGroup): JsonResponse
    {
        if (! $this->service->delete($employeeGroup)) {
            return $this->badRequest(message: 'EmployeeGroup has not been deleted.');
        }

        return $this->ok(message: 'EmployeeGroup has been deleted.');
    }
}
