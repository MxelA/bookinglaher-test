<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Repositories\RoomRepository\RoomRepository;
use Database\Seeders\ExampleSeeder;
use Database\Seeders\RoomSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class RoomRepositoryTest extends TestCase
{
    use RefreshDatabase;
    protected  Room $roomModel;
    protected Collection $rooms;


    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->roomModel = new Room();
        ;
        // Seed rooms in DB
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
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculate_all_room_capacaty()
    {
        $roomCapacity = (new RoomRepository($this->roomModel))->getRoomsCapacity();

        $this->assertEquals(12, $roomCapacity);
    }

    public function test_calculate_two_room_capacity()
    {
        $roomCapacity = (new RoomRepository($this->roomModel))->getRoomsCapacity([$this->rooms[0]->id, $this->rooms[1]->id]);

        $this->assertEquals(10, $roomCapacity);
    }
}
