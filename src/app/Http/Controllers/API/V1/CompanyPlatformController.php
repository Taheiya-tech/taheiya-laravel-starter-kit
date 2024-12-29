<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\CompanyPlatformDto;
use App\Exceptions\PlatformAlreadyFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CompanyPlatform\StoreCompanyPlatformRequest;
use App\Http\Requests\V1\CompanyPlatform\UpdateCompanyPlatformRequest;
use App\Http\Resources\V1\CompanyPlatformResource;
use App\Models\Company;
use App\Models\CompanyPlatform;
use App\Services\CompanyPlatformService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class CompanyPlatformController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function __construct(public CompanyPlatformService $service)
    {
        $this->middleware('can:viewAny,company');
        //        $this->authorizeResource(Company::class);
        $this->authorizeResource(CompanyPlatform::class);
    }

    public function index(Company $company): JsonResponse
    {
        //        $this->authorize('view', $company);
        return $this->ok($this->service->getAll(company: $company, request: request()));
    }

    public function store(Company $company, StoreCompanyPlatformRequest $request): JsonResponse
    {
        try {
            return $this->created(
                $this->service->add($company, new CompanyPlatformDto($request))
            );
        } catch (PlatformAlreadyFoundException) {
            return $this->forbidden(message: 'company Platform already exists');
        } catch (ModelNotFoundException) {
            return $this->notFound(message: 'Platform does not exist');
        }

    }

    public function show(Company $company, CompanyPlatform $companyPlatform): JsonResponse
    {
        return $this->ok($this->service->show($companyPlatform));
    }

    public function update(Company $company, UpdateCompanyPlatformRequest $request, CompanyPlatform $companyPlatform): JsonResponse
    {
        //        $this->authorize('viewAny', Company::class);
        try {
            $companyPlatform = new CompanyPlatformResource(
                $this->service
                    ->update($companyPlatform, new CompanyPlatformDto($request))
            );

            return $this->ok(data: new CompanyPlatformResource($companyPlatform), message: 'CompanyPlatform has been updated.');
        } catch (PlatformAlreadyFoundException) {
            return $this->forbidden(message: 'company Platform already exists');
        }
    }

    public function destroy(Company $company, CompanyPlatform $companyPlatform): JsonResponse
    {
        if (! $this->service->delete($companyPlatform)) {
            return $this->badRequest(message: 'CompanyPlatform has not been deleted.');
        }

        return $this->ok(message: 'CompanyPlatform has been deleted.');
    }
}
