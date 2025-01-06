<?php

namespace App\Http\Controllers;

use App\Http\Requests\YachtRequest;
use App\Http\Resources\YachtResource;
use App\Models\Yacht;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class YachtController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $searchQuery = $request->input('search');
        $typeQuery = $request->input('type');

        $yachts = Yacht::query()
            ->where('name', 'like', '%'.$searchQuery.'%')
            ->when($typeQuery, fn (Builder $builder) => $builder->where('type', $typeQuery))
            ->paginate();

        return YachtResource::collection($yachts);
    }

    public function store(YachtRequest $request): YachtResource
    {
        $yacht = Yacht::query()
            ->create($request->validated());

        return YachtResource::make($yacht);
    }

    public function update(Yacht $yacht, YachtRequest $request): YachtResource
    {
        $yacht->update($request->validated());

        return YachtResource::make($yacht);
    }

    public function destroy(Yacht $yacht): JsonResponse
    {
        $yacht->delete();

        return response()->json();
    }
}
