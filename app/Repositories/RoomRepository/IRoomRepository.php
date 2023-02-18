<?php

namespace App\Repositories\RoomRepository;

interface IRoomRepository
{
    public function getRoomCapacity(array $roomIds = null): int;
}
