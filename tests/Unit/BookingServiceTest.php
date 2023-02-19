<?php

namespace Tests\Unit;

use App\Models\Block;
use App\Models\Booking;
use App\Repositories\BlockRepository\IBlockRepository;
use App\Repositories\BookingRepository\IBookingRepository;
use App\Repositories\RoomRepository\IRoomRepository;
use App\Services\OccupancyRateService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BookingServiceTest extends TestCase
{
    protected MockObject  $roomRepositoryMock;
    protected MockObject  $bookingRepositoryMock;
    protected MockObject  $blockRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->roomRepositoryMock = $this->createMock(IRoomRepository::class);
        $this->bookingRepositoryMock = $this->createMock(IBookingRepository::class);
        $this->blockRepositoryMock = $this->createMock(IBlockRepository::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_calculate_total_occupancy_for_one_day()
    {
        $startsAt   = Carbon::create(2023,01, 02);
        $endsAt     = Carbon::create(2023,01, 02);

        $booking = new Booking();
        $booking->aggregate = 4;
        $booking->starts_at = '2023-01-01';
        $booking->ends_at = '2023-01-05';

        $this->bookingRepositoryMock
            ->method('getBookingsGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$booking]))
        ;

        $totalOccupancy = (new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock))->calculateTotalOccupancy($startsAt, $endsAt);
        $this->assertEquals(4, $totalOccupancy);

    }

    public function test_calculate_total_occupancy_for_entire_month()
    {
        $startsAt   = Carbon::create(2023,01, 01);
        $endsAt     = Carbon::create(2023,01, 31);

        $booking1 = new Booking();
        $booking1->aggregate = 4;
        $booking1->starts_at = '2023-01-01';
        $booking1->ends_at = '2023-01-05';

        $booking2 = new Booking();
        $booking2->aggregate = 1;
        $booking2->starts_at = '2023-01-03';
        $booking2->ends_at = '2023-01-08';

        $this->bookingRepositoryMock
            ->method('getBookingsGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$booking1, $booking2]))
        ;

        $totalOccupancy = (new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock))->calculateTotalOccupancy($startsAt, $endsAt);
        $this->assertEquals(26, $totalOccupancy);

    }

    public function test_calculate_total_occupancy_for_a_month()
    {
        $startsAt   = Carbon::create(2023,01, 01);
        $endsAt     = Carbon::create(2023,01, 31);

        $booking1 = new Booking();
        $booking1->aggregate = 4;
        $booking1->starts_at = '2023-01-01';
        $booking1->ends_at = '2023-01-05';

        $booking2 = new Booking();
        $booking2->aggregate = 1;
        $booking2->starts_at = '2023-01-03';
        $booking2->ends_at = '2023-01-08';

        $this->bookingRepositoryMock
            ->method('getBookingsGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$booking1, $booking2]))
        ;

        $totalOccupancy = (new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock))->calculateTotalOccupancy($startsAt, $endsAt);
        $this->assertEquals(26, $totalOccupancy);

    }

    public function test_calculate_total_occupancy_for_a_day_and_rooms()
    {
        $roomsId    = [2,3];
        $startsAt   = Carbon::create(2023,01, 06);
        $endsAt     = Carbon::create(2023,01, 6);


        $booking2 = new Booking();
        $booking2->aggregate    = 1;
        $booking2->starts_at    = '2023-01-03';
        $booking2->ends_at      = '2023-01-08';

        $this->bookingRepositoryMock
            ->method('getBookingsGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt, $roomsId)
            ->willReturn(Collection::make([$booking2]))
        ;

        $totalOccupancy = (new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock))->calculateTotalOccupancy($startsAt, $endsAt, $roomsId);
        $this->assertEquals(1, $totalOccupancy);

    }

    public function test_calculate_total_blocks_for_a_day()
    {
        $startsAt   = Carbon::create(2023,01, 02);
        $endsAt     = Carbon::create(2023,01, 02);

        $blok = new Block();
        $blok->aggregate = 1;
        $blok->starts_at = '2023-01-01';
        $blok->ends_at = '2023-01-10';

        $this->blockRepositoryMock
            ->method('getBlocksGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$blok]))
        ;

        $totalOccupancy = (new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock))->calculateTotalBlock($startsAt, $endsAt);
        $this->assertEquals(1, $totalOccupancy);

    }

    public function test_calculate_total_blocks_for_a_month()
    {
        $startsAt   = Carbon::create(2023,01, 01);
        $endsAt     = Carbon::create(2023,01, 31);

        $blok = new Block();
        $blok->aggregate = 1;
        $blok->starts_at = '2023-01-01';
        $blok->ends_at = '2023-01-10';

        $this->blockRepositoryMock
            ->method('getBlocksGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$blok]))
        ;

        $totalOccupancy = (new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock))->calculateTotalBlock($startsAt, $endsAt);
        $this->assertEquals(10, $totalOccupancy);

    }

    public function test_calculate_total_blocks_for_a_day_end_rooms()
    {
        $roomsIds   = [1,2];
        $startsAt   = Carbon::create(2023,01, 06);
        $endsAt     = Carbon::create(2023,01, 06);

        $blok = new Block();
        $blok->aggregate = 1;
        $blok->starts_at = '2023-01-01';
        $blok->ends_at = '2023-01-10';

        $this->blockRepositoryMock
            ->method('getBlocksGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt, $roomsIds)
            ->willReturn(Collection::make([$blok]))
        ;

        $totalOccupancy = (new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock))->calculateTotalBlock($startsAt, $endsAt, $roomsIds);
        $this->assertEquals(1, $totalOccupancy);

    }

    public function test_calculate_occupancies_rate_for_a_day()
    {
        $startsAt   = Carbon::create(2023,01, 02);
        $endsAt     = Carbon::create(2023,01, 02);

        $this->roomRepositoryMock
            ->expects($this->once())
            ->method('getRoomsCapacity')
            ->willReturn(12)
        ;

        $booking = new Booking();
        $booking->aggregate = 4;
        $booking->starts_at = '2023-01-01';
        $booking->ends_at = '2023-01-05';

        $this->bookingRepositoryMock
            ->expects($this->once())
            ->method('getBookingsGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$booking]))
        ;

        $blok = new Block();
        $blok->aggregate = 1;
        $blok->starts_at = '2023-01-01';
        $blok->ends_at = '2023-01-10';

        $this->blockRepositoryMock
            ->expects($this->once())
            ->method('getBlocksGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$blok]))
        ;

        $bookingService = new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock);
        $occupancies = $bookingService->calculateOccupanciesRate($startsAt, $endsAt);

        $this->assertEquals(0.36, $occupancies->occupancyRate);
    }

    public function test_calculate_occupancies_rate_for_a_month()
    {
        $startsAt   = Carbon::create(2023,01, 01);
        $endsAt     = Carbon::create(2023,01, 31);

        $this->roomRepositoryMock
            ->expects($this->once())
            ->method('getRoomsCapacity')
            ->willReturn(12)
        ;

        $booking = new Booking();
        $booking->aggregate = 4;
        $booking->starts_at = '2023-01-01';
        $booking->ends_at = '2023-01-05';

        $booking1 = new Booking();
        $booking1->aggregate = 1;
        $booking1->starts_at = '2023-01-03';
        $booking1->ends_at = '2023-01-08';

        $this->bookingRepositoryMock
            ->expects($this->once())
            ->method('getBookingsGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$booking, $booking1]))
        ;

        $blok = new Block();
        $blok->aggregate = 1;
        $blok->starts_at = '2023-01-01';
        $blok->ends_at = '2023-01-10';

        $this->blockRepositoryMock
            ->expects($this->once())
            ->method('getBlocksGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt)
            ->willReturn(Collection::make([$blok]))
        ;

        $bookingService = new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock);
        $occupancies = $bookingService->calculateOccupanciesRate($startsAt, $endsAt);

        $this->assertEquals(0.07, $occupancies->occupancyRate);
    }

    public function test_calculate_occupancies_rate_for_a_day_and_rooms()
    {
        $roomIds    = [2,3];
        $startsAt   = Carbon::create(2023,01, 06);
        $endsAt     = Carbon::create(2023,01, 06);

        $this->roomRepositoryMock
            ->expects($this->once())
            ->method('getRoomsCapacity')
            ->with($roomIds)
            ->willReturn(6)
        ;

        $booking1 = new Booking();
        $booking1->aggregate = 1;
        $booking1->starts_at = '2023-01-03';
        $booking1->ends_at = '2023-01-08';

        $this->bookingRepositoryMock
            ->expects($this->once())
            ->method('getBookingsGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt, $roomIds)
            ->willReturn(Collection::make([$booking1]))
        ;

        $blok = new Block();
        $blok->aggregate = 1;
        $blok->starts_at = '2023-01-01';
        $blok->ends_at = '2023-01-10';

        $this->blockRepositoryMock
            ->expects($this->once())
            ->method('getBlocksGroupByStartsAtEndsAt')
            ->with($startsAt, $endsAt, $roomIds)
            ->willReturn(Collection::make([$blok]))
        ;

        $bookingService = new OccupancyRateService($this->roomRepositoryMock, $this->bookingRepositoryMock, $this->blockRepositoryMock);
        $occupancies = $bookingService->calculateOccupanciesRate($startsAt, $endsAt, $roomIds);

        $this->assertEquals(0.2, $occupancies->occupancyRate);
    }

}
