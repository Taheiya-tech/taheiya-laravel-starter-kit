<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\EntityTypeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EntityType\StoreEntityTypeRequest;
use App\Http\Requests\V1\EntityType\UpdateEntityTypeRequest;
use App\Models\EntityType;
use App\Services\EntityTypeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class EntityTypeController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public EntityTypeService $service)
    {
        $this->authorizeResource(EntityType::class);
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
    public function store(StoreEntityTypeRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new EntityTypeDto($request))
        );
    }

    /**
     * Display the specified EntityType.
     */
    public function show(EntityType $entityType): JsonResponse
    {
        return $this->ok($this->service->show($entityType));
    }

    /**
     * Update the specified EntityType in storage.
     */
    public function update(UpdateEntityTypeRequest $request, EntityType $entityType): JsonResponse
    {
        $entityType = $this->service
            ->update($entityType, new EntityTypeDto($request)
            );

        return $this->ok(data: $entityType, message: 'EntityType has been updated.');
    }

    /**
     * Remove the specified EntityType from storage.
     */
    public function destroy(EntityType $entityType): JsonResponse
    {
        if (! $this->service->delete($entityType)) {
            return $this->badRequest(message: 'EntityType has not been deleted.');
        }

        return $this->ok(message: 'EntityType has been deleted.');
    }
}
