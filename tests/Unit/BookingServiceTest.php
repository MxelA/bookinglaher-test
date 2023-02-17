<?php

namespace Tests\Unit;

use App\Repositories\BlockRepository\IBlockRepository;
use App\Repositories\BookingRepository\IBookingRepository;
use App\Repositories\RoomRepository\IRoomRepository;
use App\Services\Booking\BookingService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class BookingServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_calculate_occupancies()
    {
        $roomsIds   = [1,2,3];
        $startsAt   = Carbon::create(2023,01, 02);
        $endsAt     = Carbon::create(2023,01, 02);

        $roomRepository = $this->createMock(IRoomRepository::class);
        $roomRepository->expects($this->once())
            ->method('getRoomOccupancy')
            ->willReturn(12)
        ;

        $bookingRepository = $this->createMock(IBookingRepository::class);
        $bookingRepository->expects($this->once())
            ->method('getTotalOccupancy')
            ->with($startsAt, $endsAt)
            ->willReturn(4)
        ;

        $blockRepository = $this->createMock(IBlockRepository::class);
        $blockRepository->expects($this->once())
            ->method('getTotalBlocks')
            ->with($startsAt, $endsAt)
            ->willReturn(1)
        ;

        $bookingService = new BookingService($roomRepository, $bookingRepository, $blockRepository);
        $occupancies = $bookingService->calculateOccupanciesRate($startsAt, $endsAt);

        $this->assertEquals(0.36, $occupancies);
    }
}
