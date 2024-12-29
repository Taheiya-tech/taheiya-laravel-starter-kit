<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\DeviceListDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DeviceList\StoreDeviceListRequest;
use App\Http\Requests\V1\DeviceList\UpdateDeviceListRequest;
use App\Models\DeviceList;
use App\Services\DeviceListService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class DeviceListController extends Controller
{
    use AuthorizesRequests;

    public function __construct(public DeviceListService $service)
    {
        $this->authorizeResource(DeviceList::class);
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
    public function store(StoreDeviceListRequest $request): JsonResponse
    {
        return $this->created(
            $this->service->add(new DeviceListDto($request))
        );
    }

    /**
     * Display the specified DeviceList.
     */
    public function show(DeviceList $deviceList): JsonResponse
    {
        return $this->ok($this->service->show($deviceList));
    }

    /**
     * Update the specified DeviceList in storage.
     */
    public function update(UpdateDeviceListRequest $request, DeviceList $deviceList): JsonResponse
    {
        $deviceList = $this->service
            ->update($deviceList, new DeviceListDto($request)
            );

        return $this->ok(data: $deviceList, message: 'DeviceList has been updated.');
    }

    /**
     * Remove the specified DeviceList from storage.
     */
    public function destroy(DeviceList $deviceList): JsonResponse
    {
        if (! $this->service->delete($deviceList)) {
            return $this->badRequest(message: 'DeviceList has not been deleted.');
        }

        return $this->ok(message: 'DeviceList has been deleted.');
    }
}
