<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ExceptionPolicyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExceptionPolicy\StoreExceptionPolicyRequest;
use App\Http\Requests\V1\ExceptionPolicy\UpdateExceptionPolicyRequest;
use App\Models\ExceptionPolicy;
use App\Services\ExceptionPolicyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ExceptionPolicyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ExceptionPolicyService $service)
    {
        $this->authorizeResource(ExceptionPolicy::class);
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
    public function store(StoreExceptionPolicyRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ExceptionPolicyDto($request))
        );
    }

    /**
     * Display the specified ExceptionPolicy.
     */
    public function show(ExceptionPolicy $exceptionPolicy): JsonResponse
    {
        return $this->ok($this->service->show($exceptionPolicy));
    }

    /**
     * Update the specified ExceptionPolicy in storage.
     */
    public function update(UpdateExceptionPolicyRequest $request, ExceptionPolicy $exceptionPolicy): JsonResponse
    {
        $exceptionPolicy = $this->service
            ->update($exceptionPolicy, new ExceptionPolicyDto($request)
            );

        return $this->ok(data: $exceptionPolicy, message: 'ExceptionPolicy has been updated.');
    }

    /**
     * Remove the specified ExceptionPolicy from storage.
     */
    public function destroy(ExceptionPolicy $exceptionPolicy): JsonResponse
    {
        if (! $this->service->delete($exceptionPolicy)) {
            return $this->badRequest(message: 'ExceptionPolicy has not been deleted.');
        }

        return $this->ok(message: 'ExceptionPolicy has been deleted.');
    }
}
