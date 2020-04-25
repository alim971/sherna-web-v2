<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\ReservationService;
use App\Reservation;
use App\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ReservationController extends Controller
{

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function getReservations( Request $request )
    {
        $reservations = Reservation::where('location_id', $request->get('location'))->get(['id', 'start_at', 'end_at', 'visitors_count', 'location_id', 'note', 'user_id']);
        foreach ($reservations as $reservation) {
            $owner = $reservation->user;

            $reservation->title = trans('reservations.reservation_for') . $owner->name . ' ' . $owner->surname;
            $reservation->start = $reservation->start_at->format('Y-m-d H:i');
            $reservation->end = $reservation->end_at->format('Y-m-d H:i');

            if (Auth::check() && ($owner->id == Auth::user()->id || Auth::user()->role->hasPermissionByName('Reservation Manager'))) {
                $reservation->editable = !$reservation->start_at->addMinutes(Setting::where('name', 'Time for edit'))->isPast();
                $reservation->own = $owner->id == Auth::user()->id;
            }
        }

        return Response::json($reservations);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->reservationService->makeReservation($request, Auth::user());

        return redirect()->back();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->reservationService->updateReservation($request, $reservation,  Auth::user());
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $this->reservationService->deleteReservation($reservation ,Auth::user());
        return redirect()->back();


    }
}
