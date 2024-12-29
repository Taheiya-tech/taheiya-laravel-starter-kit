<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\PlatformDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Platform\StorePlatformRequest;
use App\Http\Requests\V1\Platform\UpdatePlatformRequest;
use App\Models\Platform;
use App\Services\PlatformService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PlatformController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public PlatformService $service)
    {
        $this->authorizeResource(Platform::class);
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
    public function store(StorePlatformRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new PlatformDto($request))
        );
    }

    /**
     * Display the specified Platform.
     */
    public function show(Platform $platform): JsonResponse
    {
        return $this->ok($this->service->show($platform));
    }

    /**
     * Update the specified Platform in storage.
     */
    public function update(UpdatePlatformRequest $request, Platform $platform): JsonResponse
    {
        $platform = $this->service
            ->update($platform, new PlatformDto($request)
            );

        return $this->ok(data: $platform, message: 'Platform has been updated.');
    }

    /**
     * Remove the specified Platform from storage.
     */
    public function destroy(Platform $platform): JsonResponse
    {
        if (! $this->service->delete($platform)) {
            return $this->badRequest(message: 'Platform has not been deleted.');
        }

        return $this->ok(message: 'Platform has been deleted.');
    }
}
