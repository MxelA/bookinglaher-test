<?php

namespace App\Repositories\BookingRepository;

use Carbon\Carbon;

interface IBookingRepository
{
    public function getTotalOccupancy(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): int;
}
