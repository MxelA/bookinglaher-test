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
    public function test_calculate_occupancies_rate_example1()
    {
        $startsAt   = Carbon::create(2023,01, 02);
        $endsAt     = Carbon::create(2023,01, 02);

        $roomRepository = $this->createMock(IRoomRepository::class);
        $roomRepository->expects($this->once())
            ->method('getRoomCapacity')
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

    public function test_calculate_occupancies_rate_entire_month()
    {
        $startsAt   = Carbon::create(2023,01, 01);
        $endsAt     = Carbon::create(2023,01, 31);

        $roomRepository = $this->createMock(IRoomRepository::class);
        $roomRepository->expects($this->once())
            ->method('getRoomCapacity')
            ->willReturn(12)
        ;

        $bookingRepository = $this->createMock(IBookingRepository::class);
        $bookingRepository->expects($this->once())
            ->method('getTotalOccupancy')
            ->with($startsAt, $endsAt)
            ->willReturn(26)
        ;

        $blockRepository = $this->createMock(IBlockRepository::class);
        $blockRepository->expects($this->once())
            ->method('getTotalBlocks')
            ->with($startsAt, $endsAt)
            ->willReturn(10)
        ;

        $bookingService = new BookingService($roomRepository, $bookingRepository, $blockRepository);
        $occupancies = $bookingService->calculateOccupanciesRate($startsAt, $endsAt);

        $this->assertEquals(0.07, $occupancies);
    }

    public function test_calculate_occupancies_rate_specific_rooms()
    {
        $roomIds    = [2,3];
        $startsAt   = Carbon::create(2023,01, 06);
        $endsAt     = Carbon::create(2023,01, 06);

        $roomRepository = $this->createMock(IRoomRepository::class);
        $roomRepository->expects($this->once())
            ->method('getRoomCapacity')
            ->with($roomIds)
            ->willReturn(6)
        ;

        $bookingRepository = $this->createMock(IBookingRepository::class);
        $bookingRepository->expects($this->once())
            ->method('getTotalOccupancy')
            ->with($startsAt, $endsAt, $roomIds)
            ->willReturn(1)
        ;

        $blockRepository = $this->createMock(IBlockRepository::class);
        $blockRepository->expects($this->once())
            ->method('getTotalBlocks')
            ->with($startsAt, $endsAt, $roomIds)
            ->willReturn(1)
        ;

        $bookingService = new BookingService($roomRepository, $bookingRepository, $blockRepository);
        $occupancies = $bookingService->calculateOccupanciesRate($startsAt, $endsAt, $roomIds);

        $this->assertEquals(0.2, $occupancies);
    }
}
