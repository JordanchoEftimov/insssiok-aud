<?php

namespace App\Models;

use App\Enums\ReviewStatus;
use App\Observers\ReviewObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ReviewObserver::class)]
class Review extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => ReviewStatus::class,
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
