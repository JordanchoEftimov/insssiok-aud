<?php

namespace App\Http\Controllers;

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
        $statusQuery = $request->input('status');

        $reviews = Review::query()
            ->with('reservation.yacht')
            ->when($statusQuery, fn (Builder $builder) => $builder->where('status', $statusQuery))
            ->paginate();

        return ReviewResource::collection($reviews);
    }

    public function store(ReviewRequest $request): ReviewResource
    {
        $review = Review::query()
            ->create($request->validated());

        return ReviewResource::make($review);
    }
}
