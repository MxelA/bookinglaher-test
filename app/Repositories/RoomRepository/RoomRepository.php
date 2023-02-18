<?php

namespace App\Repositories\RoomRepository;

use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomRepository implements IRoomRepository
{
    public function getRoomCapacity(array $roomIds = null): int
    {
         return (int) Room::where(function ($query) use ($roomIds) {
                if($roomIds != null) {
                    $query = $query->whereIn('id', $roomIds);
                }
                return $query;
            })
            ->select(DB::raw('SUM(capacity) as capacity'))
            ->first()
             ->capacity
        ;
    }
}
