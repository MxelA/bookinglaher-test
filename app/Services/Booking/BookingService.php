<?php

namespace App\Services\Booking;

use App\Repositories\BlockRepository\IBlockRepository;
use App\Repositories\BookingRepository\IBookingRepository;
use App\Repositories\RoomRepository\IRoomRepository;
use Carbon\Carbon;

class BookingService implements IBookingService
{
    private IRoomRepository $roomRepository;
    private IBookingRepository $bookingRepository;
    private IBlockRepository $blockRepository;

    public function __construct(IRoomRepository $roomRepository, IBookingRepository $bookingRepository, IBlockRepository $blockRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->bookingRepository = $bookingRepository;
        $this->blockRepository = $blockRepository;
    }

    public function calculateOccupanciesRate(Carbon $startsAt, Carbon $endsAt, array|null $roomIds = null): float
    {
        $days = $startsAt->diff($endsAt)->days + 1;

        $roomsCapacity = $this->roomRepository->getRoomCapacity($roomIds);
        $totalRoomCapacity = $roomsCapacity * $days;

        $totalOccupancy = $this->bookingRepository->getTotalOccupancy($startsAt, $endsAt, $roomIds);
        $totalBlocks = $this->blockRepository->getTotalBlocks($startsAt, $endsAt, $roomIds);

        $occupancies = (float) ($totalOccupancy / ($totalRoomCapacity - $totalBlocks));
        return  round($occupancies, 2, PHP_ROUND_HALF_EVEN);
    }
}
