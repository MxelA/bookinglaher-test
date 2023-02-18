<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Repositories\RoomRepository\RoomRepository;
use Database\Seeders\ExampleSeeder;
use Database\Seeders\RoomSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculate_all_room_capacaty()
    {
        Room::factory()
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

        $roomCapacity = (new RoomRepository())->getRoomCapacity();

        $this->assertEquals(12, $roomCapacity);
    }

    public function test_calculate_two_room_capacity()
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

        $roomCapacity = (new RoomRepository())->getRoomCapacity([$rooms[0]->id, $rooms[1]->id]);

        $this->assertEquals(10, $roomCapacity);
    }
}
