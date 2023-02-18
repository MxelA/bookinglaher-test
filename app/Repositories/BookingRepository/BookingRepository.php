<?php

namespace App\Repositories\BookingRepository;

use Carbon\Carbon;

class BookingRepository implements IBookingRepository
{
    public function getTotalOccupancy(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): int
    {

        return 0;
    }
}
