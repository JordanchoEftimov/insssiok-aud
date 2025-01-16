<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use App\Observers\ReservationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ReservationObserver::class)]
class Reservation extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => ReservationStatus::class,
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
