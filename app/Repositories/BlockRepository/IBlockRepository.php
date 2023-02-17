<?php

namespace App\Repositories\BlockRepository;

use Carbon\Carbon;

interface IBlockRepository
{
    public function getTotalBlocks(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): int;
}
