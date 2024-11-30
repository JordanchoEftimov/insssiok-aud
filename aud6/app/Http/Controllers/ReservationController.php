<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();

        return view('reservations/index', compact('reservations'));
    }

    public function create()
    {
        return view('reservations/create');
    }

    public function store(Request $request): RedirectResponse
    {
        Reservation::query()->create($request->all());

        return redirect()->route('reservations.index');
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations/edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $reservation->update($request->all());

        return redirect()->route('reservations.index');
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        $reservation->delete();

        return redirect()->route('reservations.index');
    }
}
