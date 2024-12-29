<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\EmployeeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Employee\StoreEmployeeRequest;
use App\Http\Requests\V1\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public EmployeeService $service)
    {
        $this->authorizeResource(Employee::class);
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
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new EmployeeDto($request))
        );
    }

    /**
     * Display the specified Employee.
     */
    public function show(Employee $employee): JsonResponse
    {
        return $this->ok($this->service->show($employee));
    }

    /**
     * Update the specified Employee in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        $employee = $this->service
            ->update($employee, new EmployeeDto($request)
            );

        return $this->ok(data: $employee, message: 'Employee has been updated.');
    }

    /**
     * Remove the specified Employee from storage.
     */
    public function destroy(Employee $employee): JsonResponse
    {
        if (! $this->service->delete($employee)) {
            return $this->badRequest(message: 'Employee has not been deleted.');
        }

        return $this->ok(message: 'Employee has been deleted.');
    }
}
