<?php

namespace App\Repositories\RoomRepository;

interface IRoomRepository
{
    public function getRoomsCapacity(array $roomIds = null): int;
}
