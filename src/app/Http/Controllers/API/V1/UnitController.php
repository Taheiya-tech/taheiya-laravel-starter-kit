<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\UnitDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Unit\StoreUnitRequest;
use App\Http\Requests\V1\Unit\UpdateUnitRequest;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class UnitController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public UnitService $service)
    {
        $this->authorizeResource(Unit::class);
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
    public function store(StoreUnitRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new UnitDto($request))
        );
    }

    /**
     * Display the specified Unit.
     */
    public function show(Unit $unit): JsonResponse
    {
        return $this->ok($this->service->show($unit));
    }

    /**
     * Update the specified Unit in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit): JsonResponse
    {
        $unit = $this->service
            ->update($unit, new UnitDto($request)
            );

        return $this->ok(data: $unit, message: 'Unit has been updated.');
    }

    /**
     * Remove the specified Unit from storage.
     */
    public function destroy(Unit $unit): JsonResponse
    {
        if (! $this->service->delete($unit)) {
            return $this->ok(message: 'Unit does not deleted.');
        }

        return $this->ok(message: 'Unit has been deleted.');
    }
}
