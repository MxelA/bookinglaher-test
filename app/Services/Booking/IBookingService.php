<?php

namespace App\Services\Booking;

use Carbon\Carbon;

interface IBookingService
{
    public function calculateOccupanciesRate(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): float;
}
