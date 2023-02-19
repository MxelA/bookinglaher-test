<?php

namespace App\Repositories\BlockRepository;

use App\Models\Block;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlockRepository extends BaseRepository implements IBlockRepository
{
    public function __construct(Block $model)
    {
        parent::__construct($model);
    }

    public function getBlocksGroupByStartsAtEndsAt(Carbon $startsAt, Carbon $endsAt, array $roomIds = null): Collection
    {
        return $this->model->where(function ($query) use ($roomIds) {
                if($roomIds != null) {
                    $query = $query->whereIn('room_id', $roomIds);
                }
                return $query;
            })
            ->where('starts_at', '<=', $endsAt)
            ->where('ends_at', '>=', $startsAt)
            ->select(DB::raw('COUNT(id) as aggregate'), 'starts_at', 'ends_at')
            ->groupBy('starts_at', 'ends_at')
            ->get()

        ;
    }
}
