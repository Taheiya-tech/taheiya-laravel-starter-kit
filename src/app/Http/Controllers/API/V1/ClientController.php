<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ClientDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Client\StoreClientRequest;
use App\Http\Requests\V1\Client\UpdateClientRequest;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ClientService $service)
    {
        $this->authorizeResource(Client::class);
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
    public function store(storeClientRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ClientDto($request))
        );
    }

    /**
     * Display the specified Client.
     */
    public function show(Client $client): JsonResponse
    {
        return $this->ok($this->service->show($client));
    }

    /**
     * Update the specified Client in storage.
     */
    public function update(updateClientRequest $request, Client $client): JsonResponse
    {
        $client = $this->service
            ->update($client, new ClientDto($request)
            );

        return $this->ok(data: $client, message: 'Client has been updated.');
    }

    /**
     * Remove the specified Client from storage.
     */
    public function destroy(Client $client): JsonResponse
    {
        if (! $this->service->delete($client)) {
            return $this->badRequest(message: 'Client has not been deleted.');
        }

        return $this->ok(message: 'Client has been deleted.');
    }
}
