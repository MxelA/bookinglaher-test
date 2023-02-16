<?php

namespace App\Services\Booking;

interface IBookingService
{
    public function calculateOccupancies(): float;
}
