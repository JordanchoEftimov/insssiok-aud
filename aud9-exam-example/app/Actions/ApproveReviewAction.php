<?php

namespace App\Actions;

use App\Enums\ReviewStatus;
use App\Models\Review;

class ApproveReviewAction
{
    public function execute(Review $review): void
    {
        $review->update([
            'status' => ReviewStatus::APPROVED,
        ]);
    }
}
