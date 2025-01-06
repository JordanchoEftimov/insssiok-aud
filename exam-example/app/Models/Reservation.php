<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use App\Observers\ReservationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy(ReservationObserver::class)]
class Reservation extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => ReservationStatus::class,
    ];

    public function yacht(): BelongsTo
    {
        return $this->belongsTo(Yacht::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
