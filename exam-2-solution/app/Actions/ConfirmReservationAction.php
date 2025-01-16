<?php

namespace App\Actions;

use App\Enums\ReservationStatus;
use App\Models\Reservation;

class ConfirmReservationAction
{
    public function handle(Reservation $reservation): void
    {
        $event = $reservation->event;

        $event->update([
            'capacity' => $event->capacity - $reservation->ticket_quantity,
        ]);
        $reservation->update([
            'status' => ReservationStatus::CONFIRMED,
        ]);
    }
}
