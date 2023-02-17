<?php

namespace App\Repositories\RoomRepository;

use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomRepository implements IRoomRepository
{
    public function getRoomOccupancy(array $roomIds = null): int
    {
        return Room::whereIn(function ($query) use ($roomIds) {
                if($roomIds != null) {
                    $query = $query->whereIn('id', $roomIds);
                }
                return $query;
            })
            ->select(DB::raw('SUM(capacity) as capacity'))
            ->sum('capacity')
            ->get()
            ->capacity
            ;
    }
}
