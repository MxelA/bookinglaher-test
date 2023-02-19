<?php

namespace App\Repositories\BookingRepository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface IBookingRepository
{
    public function getBookingsGroupByStartsAtEndsAt(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): Collection;
}
