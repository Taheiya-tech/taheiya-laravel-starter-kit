<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\BoundaryPolicyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BoundaryPolicy\StoreBoundaryPolicyRequest;
use App\Http\Requests\V1\BoundaryPolicy\UpdateBoundaryPolicyRequest;
use App\Models\BoundaryPolicy;
use App\Services\BoundaryPolicyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class BoundaryPolicyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public BoundaryPolicyService $service)
    {
        $this->authorizeResource(BoundaryPolicy::class);
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
    public function store(StoreBoundaryPolicyRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new BoundaryPolicyDto($request))
        );
    }

    /**
     * Display the specified BoundaryPolicy.
     */
    public function show(BoundaryPolicy $boundaryPolicy): JsonResponse
    {
        return $this->ok($this->service->show($boundaryPolicy));
    }

    /**
     * Update the specified BoundaryPolicy in storage.
     */
    public function update(UpdateBoundaryPolicyRequest $request, BoundaryPolicy $boundaryPolicy): JsonResponse
    {
        $boundaryPolicy = $this->service
            ->update($boundaryPolicy, new BoundaryPolicyDto($request)
            );

        return $this->ok(data: $boundaryPolicy, message: 'BoundaryPolicy has been updated.');
    }

    /**
     * Remove the specified BoundaryPolicy from storage.
     */
    public function destroy(BoundaryPolicy $boundaryPolicy): JsonResponse
    {
        if (! $this->service->delete($boundaryPolicy)) {
            return $this->badRequest(message: 'BoundaryPolicy has not been deleted.');
        }

        return $this->ok(message: 'BoundaryPolicy has been deleted.');
    }
}
