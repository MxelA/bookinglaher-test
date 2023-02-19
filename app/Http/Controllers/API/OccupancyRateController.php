<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\GetOccupancyRateDailyRequest;
use App\Http\Requests\API\GetOccupancyRateMonthlyRequest;
use App\Http\Resources\OccupancyRateResource;
use App\Services\Booking\IOccupancyRateService;
use Illuminate\Routing\Controller as BaseController;

class OccupancyRateController extends BaseController
{
    protected IOccupancyRateService $occupancyRateService;

    public function __construct(IOccupancyRateService $occupancyRateService)
    {
        $this->occupancyRateService = $occupancyRateService;
    }

    public function getDailyOccupancyRates(GetOccupancyRateDailyRequest $request): OccupancyRateResource
    {
        return new OccupancyRateResource($this->occupancyRateService->calculateOccupanciesRate($request->input('starts_at'), $request->input('ends_at'), $request->input('room_ids')));
    }

    public function getMonthOccupancyRates(GetOccupancyRateMonthlyRequest $request): OccupancyRateResource
    {
        return new OccupancyRateResource($this->occupancyRateService->calculateOccupanciesRate($request->input('starts_at'), $request->input('ends_at'), $request->input('room_ids')));
    }
}
