<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = Room::factory()
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

        Booking::factory()
            ->count(5)
            ->state(new Sequence(
                [
                'room_id'   => $rooms[0]->id,
                'starts_at' => Carbon::createFromDate(2023, 1, 1),
                'ends_at'   => Carbon::createFromDate(2023, 1, 5)->endOfDay()
                ],
                [
                    'room_id'   => $rooms[0]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 1),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 5)->endOfDay()
                ],
                [
                    'room_id'   => $rooms[0]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 1),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 5)->endOfDay()
                ],
                [
                    'room_id'   => $rooms[1]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 1),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 5)->endOfDay()
                ],
                [
                    'room_id'   => $rooms[1]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 3),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 8)->endOfDay()
                ]
            ))
            ->create();

        Block::factory()
            ->create(
                [
                    'room_id'   => $rooms[1]->id,
                    'starts_at' => Carbon::createFromDate(2023, 1, 1),
                    'ends_at'   => Carbon::createFromDate(2023, 1, 10)
                ],
            );
        ;
    }
}
