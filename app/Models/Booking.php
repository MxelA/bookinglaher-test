<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_id',
        'starts_at',
        'ends_at',
    ];

    protected  $casts = [
        'starts_at'  => 'date:Y-m-d',
        'ends_at'  => 'date:Y-m-d',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function factory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return BookingFactory::new();
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
