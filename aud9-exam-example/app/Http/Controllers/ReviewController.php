<?php

namespace App\Http\Controllers;

use App\Actions\ApproveReviewAction;
use App\Actions\DeclineReviewAction;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReviewController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $status = $request->input('status');

        $reviews = Review::query()
            ->when($status, fn (Builder $builder) => $builder->where('status', $status))
            ->paginate();

        return ReviewResource::collection($reviews);
    }

    public function show(Review $review): ReviewResource
    {
        $review->loadMissing('jet');

        return ReviewResource::make($review);
    }

    public function store(ReviewRequest $request): ReviewResource
    {
        $review = Review::query()
            ->create($request->validated());

        return ReviewResource::make($review);
    }

    public function approveReview(Review $review): ReviewResource
    {
        (new ApproveReviewAction)->execute($review);

        return ReviewResource::make($review);
    }

    public function declineReview(Review $review): ReviewResource
    {
        (new DeclineReviewAction)->execute($review);

        return ReviewResource::make($review);
    }
}
