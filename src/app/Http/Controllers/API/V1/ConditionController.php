<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ConditionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Condition\StoreConditionRequest;
use App\Http\Requests\V1\Condition\UpdateConditionRequest;
use App\Models\Condition;
use App\Services\ConditionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ConditionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ConditionService $service)
    {
        $this->authorizeResource(Condition::class);
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
    public function store(StoreConditionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ConditionDto($request))
        );
    }

    /**
     * Display the specified Condition.
     */
    public function show(Condition $condition): JsonResponse
    {
        return $this->ok($this->service->show($condition));
    }

    /**
     * Update the specified Condition in storage.
     */
    public function update(UpdateConditionRequest $request, Condition $condition): JsonResponse
    {
        $condition = $this->service
            ->update($condition, new ConditionDto($request)
            );

        return $this->ok(data: $condition, message: 'Condition has been updated.');
    }

    /**
     * Remove the specified Condition from storage.
     */
    public function destroy(Condition $condition): JsonResponse
    {
        if (! $this->service->delete($condition)) {
            return $this->badRequest(message: 'Condition has not been deleted.');
        }

        return $this->ok(message: 'Condition has been deleted.');
    }
}
