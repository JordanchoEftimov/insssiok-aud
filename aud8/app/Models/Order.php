<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'amount', 'status',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];
}
