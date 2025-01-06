<?php

namespace App\Actions;

use App\Enums\ReservationStatus;
use App\Models\Reservation;

class CancelReservation
{
    public function execute(Reservation $reservation): void
    {
        $reservation->update([
            'status' => ReservationStatus::CANCELLED,
        ]);
    }
}
