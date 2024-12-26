<?php

namespace App\Actions;

use App\Enums\ReviewStatus;
use App\Models\Review;

class DeclineReviewAction
{
    public function execute(Review $review): void
    {
        $review->update([
            'status' => ReviewStatus::DECLINED,
        ]);
    }
}
