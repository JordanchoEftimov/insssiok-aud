<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventShowResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $search = $request->get('search');

        $events = Event::query()
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('location', 'like', '%'.$search.'%')
            ->paginate();

        return EventResource::collection($events);
    }

    public function store(EventRequest $request): EventResource
    {
        $event = Event::query()
            ->create($request->validated());

        return EventResource::make($event);
    }

    public function update(Event $event, EventRequest $request): EventResource
    {
        $event->update($request->validated());

        return EventResource::make($event);
    }

    public function destroy(Event $event): JsonResponse
    {
        // Прв начин на решавање
        //        abort_if($event->confirmedReservations()->exists(), 400);

        // Втор начин на решавање
        //        abort_if($event->reservations()
        //            ->where('status', ReservationStatus::CONFIRMED)
        //            ->exists(),
        //            400);

        // Трет начин на решавање
        abort_if($event->reservations()
            ->where('status', ReservationStatus::CONFIRMED)
            ->count() > 0,
            400);

        $event->delete();

        return response()->json();
    }

    public function show(Event $event): EventShowResource
    {
        $event->loadMissing('reservations');

        return EventShowResource::make($event);
    }
}
