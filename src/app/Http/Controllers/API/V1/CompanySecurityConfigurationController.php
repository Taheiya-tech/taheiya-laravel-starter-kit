<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\CompanySecurityConfigurationDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CompanySecuirtyConfiguration\StoreCompanySecurityConfigrationRequest;
use App\Http\Requests\V1\CompanySecuirtyConfiguration\UpdateCompanySecurityConfigrationRequest;
use App\Models\CompanySecurityConfiguration;
use App\Services\CompanySecurityConfigurationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class CompanySecurityConfigurationController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public CompanySecurityConfigurationService $service)
    {
        $this->authorizeResource(CompanySecurityConfiguration::class);
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
    public function store(StoreCompanySecurityConfigrationRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new CompanySecurityConfigurationDto($request))
        );
    }

    /**
     * Display the specified CompanySecurityConfiguration.
     */
    public function show(CompanySecurityConfiguration $companySecurityConfiguration): JsonResponse
    {
        return $this->ok($this->service->show($companySecurityConfiguration));
    }

    /**
     * Update the specified CompanySecurityConfiguration in storage.
     */
    public function update(UpdateCompanySecurityConfigrationRequest $request, CompanySecurityConfiguration $companySecurityConfiguration): JsonResponse
    {
        $companySecurityConfiguration = $this->service
            ->update($companySecurityConfiguration, new CompanySecurityConfigurationDto($request)
            );

        return $this->ok(data: $companySecurityConfiguration, message: 'CompanySecurityConfiguration has been updated.');
    }

    /**
     * Remove the specified CompanySecurityConfiguration from storage.
     */
    public function destroy(CompanySecurityConfiguration $companySecurityConfiguration): JsonResponse
    {
        if (! $this->service->delete($companySecurityConfiguration)) {
            return $this->badRequest(message: 'CompanySecurityConfiguration has not been deleted.');
        }

        return $this->ok(message: 'CompanySecurityConfiguration has been deleted.');
    }
}
