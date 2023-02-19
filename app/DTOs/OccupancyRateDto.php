<?php

namespace App\DTOs;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class OccupancyRateDto extends Data
{
    public function __construct(
        public readonly float $occupancyRate,
        public readonly array|null $roomIds,
        public readonly Carbon $startsAt,
        public readonly Carbon $endsAt
    ){}
}
