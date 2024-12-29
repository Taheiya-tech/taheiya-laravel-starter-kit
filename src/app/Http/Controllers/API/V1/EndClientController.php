<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\EndClientDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EndClient\StoreEndClientRequest;
use App\Http\Requests\V1\EndClient\UpdateEndClientRequest;
use App\Models\EndClient;
use App\Services\EndClientService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class EndClientController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public EndClientService $service)
    {
        $this->authorizeResource(EndClient::class);
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
    public function store(StoreEndClientRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new EndClientDto($request))
        );
    }

    /**
     * Display the specified EndClient.
     */
    public function show(EndClient $endClient): JsonResponse
    {
        return $this->ok($this->service->show($endClient));
    }

    /**
     * Update the specified EndClient in storage.
     */
    public function update(UpdateEndClientRequest $request, EndClient $endClient): JsonResponse
    {
        $endClient = $this->service
            ->update($endClient, new EndClientDto($request)
            );

        return $this->ok(data: $endClient, message: 'EndClient has been updated.');
    }

    /**
     * Remove the specified EndClient from storage.
     */
    public function destroy(EndClient $endClient): JsonResponse
    {
        if (! $this->service->delete($endClient)) {
            return $this->badRequest(message: 'EndClient has not been deleted.');
        }

        return $this->ok(message: 'EndClient has been deleted.');
    }
}
