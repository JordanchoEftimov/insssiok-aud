<?php

namespace App\Http\Controllers;

use App\Actions\CancelReservation;
use App\Actions\ConfirmReservation;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $statusQuery = $request->input('status');

        $reservations = Reservation::query()
            ->with('yacht')
            ->when($statusQuery, fn (Builder $builder) => $builder->where('status', $statusQuery))
            ->paginate();

        return ReservationResource::collection($reservations);
    }

    public function store(ReservationRequest $request): ReservationResource
    {
        $reservation = Reservation::query()
            ->create($request->validated());

        return ReservationResource::make($reservation);
    }

    public function confirmReservation(Reservation $reservation): ReservationResource
    {
        (new ConfirmReservation)->execute($reservation);

        return ReservationResource::make($reservation);
    }

    public function cancelReservation(Reservation $reservation): ReservationResource
    {
        (new CancelReservation)->execute($reservation);

        return ReservationResource::make($reservation);
    }
}
