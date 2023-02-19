<?php

namespace App\Services;

use App\DTOs\OccupancyRateDto;
use App\Repositories\BlockRepository\IBlockRepository;
use App\Repositories\BookingRepository\IBookingRepository;
use App\Repositories\RoomRepository\IRoomRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class OccupancyRateService implements IOccupancyRateService
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

    public function calculateTotalOccupancy(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): int
    {
        $bookings = $this->bookingRepository->getBookingsGroupByStartsAtEndsAt($startsAt, $endsAt, $roomIds);

        return $this->processRepositoryData($bookings, $startsAt, $endsAt);
    }

    public function calculateTotalBlock(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): int
    {
        $blocks = $this->blockRepository->getBlocksGroupByStartsAtEndsAt($startsAt, $endsAt, $roomIds);

        return $this->processRepositoryData($blocks, $startsAt, $endsAt);
    }

    public function calculateOccupanciesRate(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): OccupancyRateDto
    {
        $days = $startsAt->diff($endsAt)->days + 1;

        $roomsCapacity      = $this->roomRepository->getRoomsCapacity($roomIds);
        $totalRoomCapacity  = $roomsCapacity * $days;

        $totalOccupancy = $this->calculateTotalOccupancy($startsAt, $endsAt, $roomIds);
        $totalBlocks    = $this->calculateTotalBlock($startsAt, $endsAt, $roomIds);

        $occupancies = (float) ($totalOccupancy / ($totalRoomCapacity - $totalBlocks));

        return new OccupancyRateDto(
            round($occupancies, 2, PHP_ROUND_HALF_EVEN),
            $roomIds,
            $startsAt,
            $endsAt
        );
    }


    private function processRepositoryData(Collection $models, Carbon $startsAt, Carbon $endsAt): int
    {
        if($models->isEmpty())
            return 0;

        $diffDays = $startsAt->diff($endsAt)->days + 1;

        return $models->sum(function ($model) use ($diffDays) {
            $startsAt   = Carbon::parse($model->starts_at);
            $endsAt     = Carbon::parse($model->ends_at);

            $modelDiffDays = $startsAt->diff($endsAt)->days + 1;

            if($diffDays >= $modelDiffDays)
                $diffDays = $modelDiffDays;

            return (int) ($model->aggregate * $diffDays);
        });
    }
}
