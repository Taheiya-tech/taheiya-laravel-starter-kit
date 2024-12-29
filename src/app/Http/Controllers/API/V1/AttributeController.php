<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\AttributeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Attribute\StoreAttributeRequest;
use App\Http\Requests\V1\Attribute\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Services\AttributeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public AttributeService $service)
    {
        $this->authorizeResource(Attribute::class);
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
    public function store(StoreAttributeRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new AttributeDto($request))
        );
    }

    /**
     * Display the specified Attribute.
     */
    public function show(Attribute $attribute): JsonResponse
    {
        return $this->ok($this->service->show($attribute));
    }

    /**
     * Update the specified Attribute in storage.
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute): JsonResponse
    {
        $attribute = $this->service
            ->update($attribute, new AttributeDto($request)
            );

        return $this->ok(data: $attribute, message: 'Attribute has been updated.');
    }

    /**
     * Remove the specified Attribute from storage.
     */
    public function destroy(Attribute $attribute): JsonResponse
    {
        if (! $this->service->delete($attribute)) {
            return $this->badRequest(message: 'Attribute has not been deleted.');
        }

        return $this->ok(message: 'Attribute has been deleted.');
    }
}
