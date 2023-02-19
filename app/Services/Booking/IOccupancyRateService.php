<?php

namespace App\Services\Booking;

use App\DTOs\OccupancyRateDto;
use Carbon\Carbon;

interface IOccupancyRateService
{
    public function calculateOccupanciesRate(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): OccupancyRateDto;
    public function calculateTotalOccupancy(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): int;
    public function calculateTotalBlock(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): int;
}
