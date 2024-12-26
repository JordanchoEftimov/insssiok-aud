<?php

namespace App\Observers;

use App\Models\Jet;

class JetObserver
{
    /**
     * Handle the Jet "created" event.
     */
    public function created(Jet $jet): void
    {
        //
    }

    /**
     * Handle the Jet "updated" event.
     */
    public function updated(Jet $jet): void
    {
        //
    }

    /**
     * Handle the Jet "deleting" event.
     */
    public function deleting(Jet $jet): void
    {
        $jet->reviews()->delete();
    }

    /**
     * Handle the Jet "deleted" event.
     */
    public function deleted(Jet $jet): void
    {
        //
    }

    /**
     * Handle the Jet "restored" event.
     */
    public function restored(Jet $jet): void
    {
        //
    }

    /**
     * Handle the Jet "force deleted" event.
     */
    public function forceDeleted(Jet $jet): void
    {
        //
    }
}
