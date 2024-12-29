<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\EmployeePolicyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EmployeePolicy\StoreEmployeePolicyRequest;
use App\Http\Requests\V1\EmployeePolicy\UpdateEmployeePolicyRequest;
use App\Models\EmployeePolicy;
use App\Services\EmployeePolicyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class EmployeePolicyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public EmployeePolicyService $service)
    {
        $this->authorizeResource(EmployeePolicy::class);
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
    public function store(StoreEmployeePolicyRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new EmployeePolicyDto($request))
        );
    }

    /**
     * Display the specified EmployeePolicy.
     */
    public function show(EmployeePolicy $employeePolicy): JsonResponse
    {
        return $this->ok($this->service->show($employeePolicy));
    }

    /**
     * Update the specified EmployeePolicy in storage.
     */
    public function update(UpdateEmployeePolicyRequest $request, EmployeePolicy $employeePolicy): JsonResponse
    {
        $employeePolicy = $this->service
            ->update($employeePolicy, new EmployeePolicyDto($request)
            );

        return $this->ok(data: $employeePolicy, message: 'EmployeePolicy has been updated.');
    }

    /**
     * Remove the specified EmployeePolicy from storage.
     */
    public function destroy(EmployeePolicy $employeePolicy): JsonResponse
    {
        if (! $this->service->delete($employeePolicy)) {
            return $this->badRequest(message: 'EmployeePolicy has not been deleted.');
        }

        return $this->ok(message: 'EmployeePolicy has been deleted.');
    }
}
