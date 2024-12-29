<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\BoundaryDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Boundary\StoreBoundaryRequest;
use App\Http\Requests\V1\Boundary\UpdateBoundaryRequest;
use App\Models\Boundary;
use App\Services\BoundaryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class BoundaryController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public BoundaryService $service)
    {
        $this->authorizeResource(Boundary::class);
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
    public function store(StoreBoundaryRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new BoundaryDto($request))
        );
    }

    /**
     * Display the specified Boundary.
     */
    public function show(Boundary $boundary): JsonResponse
    {
        return $this->ok($this->service->show($boundary));
    }

    /**
     * Update the specified Boundary in storage.
     */
    public function update(UpdateBoundaryRequest $request, Boundary $boundary): JsonResponse
    {
        $boundary = $this->service
            ->update($boundary, new BoundaryDto($request)
            );

        return $this->ok(data: $boundary, message: 'Boundary has been updated.');
    }

    /**
     * Remove the specified Boundary from storage.
     */
    public function destroy(Boundary $boundary): JsonResponse
    {
        if (! $this->service->delete($boundary)) {
            return $this->badRequest(message: 'Boundary has not been deleted.');
        }

        return $this->ok(message: 'Boundary has been deleted.');
    }
}
