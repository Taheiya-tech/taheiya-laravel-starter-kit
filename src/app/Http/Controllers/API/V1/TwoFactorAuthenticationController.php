<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\TwoFactorAuthenticationDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\TwoFactorAuthentication\StoreTwoFactorAuthenticationRequest;
use App\Http\Requests\V1\TwoFactorAuthentication\UpdateTwoFactorAuthenticationRequest;
use App\Models\TwoFactorAuthentication;
use App\Services\TwoFactorAuthenticationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class TwoFactorAuthenticationController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public TwoFactorAuthenticationService $service)
    {
        $this->authorizeResource(TwoFactorAuthentication::class);
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
    public function store(StoreTwoFactorAuthenticationRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new TwoFactorAuthenticationDto($request))
        );
    }

    /**
     * Display the specified TwoFactorAuthentication.
     */
    public function show(TwoFactorAuthentication $twoFactorAuthentication): JsonResponse
    {
        return $this->ok($this->service->show($twoFactorAuthentication));
    }

    /**
     * Update the specified TwoFactorAuthentication in storage.
     */
    public function update(UpdateTwoFactorAuthenticationRequest $request, TwoFactorAuthentication $twoFactorAuthentication): JsonResponse
    {
        $twoFactorAuthentication = $this->service
            ->update($twoFactorAuthentication, new TwoFactorAuthenticationDto($request)
            );

        return $this->ok(data: $twoFactorAuthentication, message: 'TwoFactorAuthentication has been updated.');
    }

    /**
     * Remove the specified TwoFactorAuthentication from storage.
     */
    public function destroy(TwoFactorAuthentication $twoFactorAuthentication): JsonResponse
    {
        if (! $this->service->delete($twoFactorAuthentication)) {
            return $this->badRequest(message: 'TwoFactorAuthentication has not been deleted.');
        }

        return $this->ok(message: 'TwoFactorAuthentication has been deleted.');
    }
}
