<?php

namespace App\Repositories\BookingRepository;

use App\Models\Booking;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookingRepository extends BaseRepository implements IBookingRepository
{
    public function __construct(Booking $model)
    {
        parent::__construct($model);
    }

    public function getBookingsGroupByStartsAtEndsAt(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): Collection
    {
        return $this->model->where(function ($query) use ($roomIds) {
                if($roomIds != null) {
                    $query = $query->whereIn('room_id', $roomIds);
                }
                return $query;
            })
            ->where('starts_at', '<=', $endsAt)
            ->where('ends_at', '>=', $startsAt)
            ->select(DB::raw('COUNT(id) as aggregate'), 'starts_at', 'ends_at')
            ->groupBy('starts_at', 'ends_at')
            ->get()
        ;
    }
}
