<?php

namespace App\Repositories\BookingRepository;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingRepository implements IBookingRepository
{
    public function getTotalOccupancy(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): int
    {
        $diffDays = $startsAt->diff($endsAt)->days + 1;

        $bookings = Booking::
            where('starts_at', '<=', $endsAt)
            ->where('ends_at', '>=', $startsAt)
            ->select(DB::raw('COUNT(id) as aggregate'), 'starts_at', 'ends_at')
            ->groupBy('starts_at', 'ends_at')
            ->get()
        ;

        return $bookings->sum(function ($booking) use ($diffDays) {
            $startsAt   = Carbon::parse($booking->starts_at);
            $endsAt     = Carbon::parse($booking->ends_at);

            $bookingDiffDays = $startsAt->diff($endsAt)->days + 1;

            if($diffDays >= $bookingDiffDays)
                $diffDays = $bookingDiffDays;

            return (int) ($booking->aggregate * $diffDays);
        });

    }
}
