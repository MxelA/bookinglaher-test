<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Repositories\BookingRepository\BookingRepository;
use App\Repositories\RoomRepository\RoomRepository;
use Carbon\Carbon;
use Database\Seeders\ExampleSeeder;
use Database\Seeders\RoomSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingRepositoryTest extends TestCase
{
    use RefreshDatabase;
    protected Collection $rooms;
    protected Collection $bookings;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        // seed rooms
        $this->rooms = Room::factory()
            ->count(3)
            ->state(new Sequence(
                [
                    'name' => 'Room A',
                    'capacity' => 6
                ],
                [
                    'name' => 'Room B',
                    'capacity' => 4
                ],
                [
                    'name' => 'Room C',
                    'capacity' => 2
                ],
            ))
            ->create();

        // seed bookings
        Booking::factory()
            ->count(5)
            ->state(new Sequence(
                [
                    'room_id'   => $this->rooms[0]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 1),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 5)->endOfDay()
                ],
                [
                    'room_id'   => $this->rooms[0]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 1),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 5)->endOfDay()
                ],
                [
                    'room_id'   => $this->rooms[0]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 1),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 5)->endOfDay()
                ],
                [
                    'room_id'   => $this->rooms[1]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 1),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 5)->endOfDay()
                ],
                [
                    'room_id'   => $this->rooms[1]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 3),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 8)->endOfDay()
                ]
            ))
            ->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculate_total_occupancy_for_specific_day()
    {

        $startsAt   = Carbon::create(2023,01,2);
        $endsAt     = Carbon::create(2023,01,2);
        $bookings   = (new BookingRepository())->getBookingsGroupByStartsAtEndsAt($startsAt, $endsAt);

        $expected = [
            [
                "aggregate" => 4,
                "starts_at" => "2023-01-01",
                "ends_at" => "2023-01-05"
            ]
        ];

        $this->assertEquals(json_encode($expected), json_encode($bookings->toArray()));
    }

    public function test_calculate_total_occupancy_for_a_mount()
    {
        $startsAt   = Carbon::create(2023,01,1);
        $endsAt     = Carbon::create(2023,01,31);
        $bookings = (new BookingRepository())->getBookingsGroupByStartsAtEndsAt($startsAt, $endsAt);

        $expected = [
            [
            "aggregate" => 4,
            "starts_at" => "2023-01-01",
            "ends_at" => "2023-01-05"
            ],
            [
            "aggregate" => 1,
            "starts_at" => "2023-01-03",
            "ends_at" => "2023-01-08"
            ]
        ];

        $this->assertEquals(json_encode($expected), json_encode($bookings->toArray()));
    }

    public function test_calculate_total_occupancy_for_specific_day_and_rooms()
    {
        $startsAt   = Carbon::create(2023,01,6);
        $endsAt     = Carbon::create(2023,01,6);
        $bookings   = (new BookingRepository())->getBookingsGroupByStartsAtEndsAt($startsAt, $endsAt, [$this->rooms[1]->id, $this->rooms[2]->id]);

        $expected = [
            [
                "aggregate" => 1,
                "starts_at" => "2023-01-03",
                "ends_at" => "2023-01-08"
            ]
        ];
        $this->assertEquals(json_encode($expected), json_encode($bookings->toArray()));
    }
}
