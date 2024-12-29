<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ResourceDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Resource\StoreResourceRequest;
use App\Http\Requests\V1\Resource\UpdateResourceRequest;
use App\Models\Resource;
use App\Services\ResourceService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ResourceController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ResourceService $service)
    {
        $this->authorizeResource(Resource::class);
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
    public function store(StoreResourceRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ResourceDto($request))
        );
    }

    /**
     * Display the specified Resource.
     */
    public function show(Resource $resource): JsonResponse
    {
        return $this->ok($this->service->show($resource));
    }

    /**
     * Update the specified Resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource): JsonResponse
    {
        $resource = $this->service
            ->update($resource, new ResourceDto($request)
            );

        return $this->ok(data: $resource, message: 'Resource has been updated.');
    }

    /**
     * Remove the specified Resource from storage.
     */
    public function destroy(Resource $resource): JsonResponse
    {
        if (! $this->service->delete($resource)) {
            return $this->badRequest(message: 'Resource has not been deleted.');
        }

        return $this->ok(message: 'Resource has been deleted.');
    }
}
