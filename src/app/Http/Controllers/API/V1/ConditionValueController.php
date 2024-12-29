<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ConditionValueDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ConditionValue\StoreConditionValueRequest;
use App\Http\Requests\V1\ConditionValue\UpdateConditionValueRequest;
use App\Models\ConditionValue;
use App\Services\ConditionValueService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ConditionValueController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ConditionValueService $service)
    {
        $this->authorizeResource(ConditionValue::class);
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
    public function store(StoreConditionValueRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ConditionValueDto($request))
        );
    }

    /**
     * Display the specified ConditionValue.
     */
    public function show(ConditionValue $conditionValue): JsonResponse
    {
        return $this->ok($this->service->show($conditionValue));
    }

    /**
     * Update the specified ConditionValue in storage.
     */
    public function update(UpdateConditionValueRequest $request, ConditionValue $conditionValue): JsonResponse
    {
        $conditionValue = $this->service
            ->update($conditionValue, new ConditionValueDto($request)
            );

        return $this->ok(data: $conditionValue, message: 'ConditionValue has been updated.');
    }

    /**
     * Remove the specified ConditionValue from storage.
     */
    public function destroy(ConditionValue $conditionValue): JsonResponse
    {
        if (! $this->service->delete($conditionValue)) {
            return $this->badRequest(message: 'ConditionValue has not been deleted.');
        }

        return $this->ok(message: 'ConditionValue has been deleted.');
    }
}
