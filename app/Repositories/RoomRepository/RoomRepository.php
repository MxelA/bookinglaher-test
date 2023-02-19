<?php

namespace App\Repositories\RoomRepository;

use App\Models\Room;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RoomRepository extends BaseRepository implements IRoomRepository
{
    protected $model;

    public function __construct(Room $room)
    {
        $this->model = $room;
    }

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
