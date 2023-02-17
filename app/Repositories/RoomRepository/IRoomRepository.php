<?php

namespace App\Repositories\RoomRepository;

interface IRoomRepository
{
    public function getRoomOccupancy(array $roomIds = null): int;
}
