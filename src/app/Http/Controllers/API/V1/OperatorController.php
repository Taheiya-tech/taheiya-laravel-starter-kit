<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\OperatorDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Operator\StoreOperatorRequest;
use App\Http\Requests\V1\Operator\UpdateOperatorRequest;
use App\Models\Operator;
use App\Services\OperatorService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class OperatorController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public OperatorService $service)
    {
        $this->authorizeResource(Operator::class);
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
    public function store(StoreOperatorRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new OperatorDto($request))
        );
    }

    /**
     * Display the specified Operator.
     */
    public function show(Operator $operator): JsonResponse
    {
        return $this->ok($this->service->show($operator));
    }

    /**
     * Update the specified Operator in storage.
     */
    public function update(UpdateOperatorRequest $request, Operator $operator): JsonResponse
    {
        $operator = $this->service
            ->update($operator, new OperatorDto($request)
            );

        return $this->ok(data: $operator, message: 'Operator has been updated.');
    }

    /**
     * Remove the specified Operator from storage.
     */
    public function destroy(Operator $operator): JsonResponse
    {
        if (! $this->service->delete($operator)) {
            return $this->badRequest(message: 'Operator has not been deleted.');
        }

        return $this->ok(message: 'Operator has been deleted.');
    }
}
