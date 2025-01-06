<?php

namespace App\Models;

use App\Enums\YachtType;
use App\Observers\YachtObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(YachtObserver::class)]
class Yacht extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => YachtType::class,
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
