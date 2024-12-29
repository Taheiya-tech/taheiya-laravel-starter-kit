<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ActionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Action\StoreActionRequest;
use App\Http\Requests\V1\Action\UpdateActionRequest;
use App\Models\Action;
use App\Services\ActionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\JsonResponse;

class ActionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public ActionService $service)
    {
        $this->authorizeResource(Action::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @group Action
     *
     * @unauthenticated
     */
    public function index(): JsonResponse
    {

        return $this->ok($this->service->getAll(request: request()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @group Action
     */
    public function store(storeActionRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new ActionDto($request))
        );
    }

    /**
     * Display the specified Action.
     *
     * @group Action
     */
    public function show(Action $action): JsonResponse
    {
        return $this->ok($this->service->show($action));
    }

    /**
     * Update the specified Action in storage.
     *
     * @group Action
     */
    public function update(updateActionRequest $request, Action $action): JsonResponse
    {
        $action = $this->service
            ->update($action, new ActionDto($request)
            );

        return $this->ok(data: $action, message: 'Action has been updated.');
    }

    /**
     * Remove the specified Action from storage.
     *
     * @group Action
     */
    public function destroy(Action $action): JsonResponse
    {
        if (! $this->service->delete($action)) {
            return $this->badRequest(message: 'Action has not been deleted.');
        }

        return $this->ok(message: 'Action has been deleted.');
    }
}
