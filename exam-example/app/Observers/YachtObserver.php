<?php

namespace App\Observers;

use App\Models\Reservation;
use App\Models\Yacht;

class YachtObserver
{
    /**
     * Handle the Yacht "created" event.
     */
    public function created(Yacht $yacht): void
    {
        //
    }

    /**
     * Handle the Yacht "updated" event.
     */
    public function updated(Yacht $yacht): void
    {
        //
    }

    /**
     * Handle the Yacht "deleting" event.
     */
    public function deleting(Yacht $yacht): void
    {
        $yacht->reservations()
            ->each(fn (Reservation $reservation) => $reservation->review()->delete());
        $yacht->reservations()->delete();
    }

    /**
     * Handle the Yacht "deleted" event.
     */
    public function deleted(Yacht $yacht): void
    {
        //
    }

    /**
     * Handle the Yacht "restored" event.
     */
    public function restored(Yacht $yacht): void
    {
        //
    }

    /**
     * Handle the Yacht "force deleted" event.
     */
    public function forceDeleted(Yacht $yacht): void
    {
        //
    }
}
