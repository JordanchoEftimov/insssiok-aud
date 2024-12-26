<?php

namespace App\Http\Controllers;

use App\Http\Requests\JetRequest;
use App\Http\Resources\JetResource;
use App\Models\Jet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class JetController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $searchQuery = $request->input('search');

        $jets = Jet::query()
            ->where('name', 'like', '%'.$searchQuery.'%')
            ->orWhere('model', 'like', '%'.$searchQuery.'%')
            ->paginate();

        return JetResource::collection($jets);
    }

    public function show(Jet $jet): JetResource
    {
        $jet->loadMissing('reviews');

        return JetResource::make($jet);
    }

    public function store(JetRequest $request): JetResource
    {
        $jet = Jet::query()
            ->create($request->validated());

        return JetResource::make($jet);
    }

    public function update(Jet $jet, JetRequest $request): JetResource
    {
        $jet->update($request->validated());

        return JetResource::make($jet);
    }

    public function destroy(Jet $jet): JsonResource
    {
        $jet->delete();

        return JsonResource::make([
            'message' => 'Successfully deleted Jet',
        ]);
    }
}
