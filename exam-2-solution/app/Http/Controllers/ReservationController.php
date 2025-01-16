<?php

namespace App\Http\Controllers;

use App\Actions\CancelReservationAction;
use App\Actions\ConfirmReservationAction;
use App\Enums\ReservationStatus;
use App\Http\Requests\ReservationRequest;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request): JsonResource
    {
        $ticketQuantity = $request->input('ticket_quantity');
        $eventId = $request->input('event_id');
        $event = Event::query()->findOrFail($eventId);

        abort_if($event->capacity - $ticketQuantity < 0, 400);

        $reservation = Reservation::query()
            ->create($request->validated());

        return JsonResource::make($reservation);
    }

    public function confirm(Reservation $reservation): JsonResponse
    {
        abort_if($reservation->status !== ReservationStatus::PENDING, 400);

        (new ConfirmReservationAction)->handle($reservation);

        return response()->json();
    }

    public function cancel(Reservation $reservation): JsonResponse
    {
        abort_if($reservation->status !== ReservationStatus::CONFIRMED, 400);

        (new CancelReservationAction)->handle($reservation);

        return response()->json();
    }
}
