<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\CompanyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Company\StoreCompanyRequest;
use App\Http\Requests\V1\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public CompanyService $service)
    {
        $this->authorizeResource(Company::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        //        if(request()->user()->cannot('viewAny', Company::class)) {
        //            dd("errlr");
        //        }
        return $this->ok($this->service->getAll(request: request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new CompanyDto($request))
        );
    }

    /**
     * Display the specified Company.
     */
    public function show(Company $company): JsonResponse
    {
        return $this->ok($this->service->show($company));
    }

    /**
     * Update the specified Company in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company): JsonResponse
    {
        $company = $this->service
            ->update($company, new CompanyDto($request)
            );

        return $this->ok(data: $company, message: 'Company has been updated.');
    }

    /**
     * Remove the specified Company from storage.
     */
    public function destroy(Company $company): JsonResponse
    {
        if (! $this->service->delete($company)) {
            return $this->badRequest(message: 'Company has not been deleted.');
        }

        return $this->ok(message: 'Company has been deleted.');
    }
}
