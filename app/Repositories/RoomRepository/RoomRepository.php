<?php

namespace App\Repositories\RoomRepository;

use App\Models\Room;

class RoomRepository implements IRoomRepository
{
    public function getRoomsCapacity(array $roomIds = null): int
    {
         return (int) Room::where(function ($query) use ($roomIds) {
                if($roomIds != null) {
                    $query = $query->whereIn('id', $roomIds);
                }
                return $query;
            })
            ->sum('capacity')
        ;
    }
}
