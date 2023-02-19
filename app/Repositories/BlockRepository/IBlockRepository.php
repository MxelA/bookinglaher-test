<?php

namespace App\Repositories\BlockRepository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface IBlockRepository
{
    public function getBlocksGroupByStartsAtEndsAt(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): Collection;
}
