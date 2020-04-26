<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\ReservationService;
use App\Models\Reservations\Reservation;
use App\Models\Settings\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ReservationController extends Controller
{

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function getReservations(Request $request)
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

    public function index()
    {
        return redirect()->route('pages.show', ['page' => 'reservation']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = $this->reservationService->makeReservation($request, Auth::user());
        if (!is_string($validation)) {
            flash(trans('reservations.success_added'))->error();
        } else {
            flash(trans($validation))->error();
        }

        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validation = $this->reservationService->updateReservation($request, $reservation, Auth::user());
        if (!is_string($validation)) {
            flash(trans('reservations.success_updated'))->success();
        } else {
            flash(trans($validation))->error();
        }
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        if ($this->reservationService->deleteReservation($reservation, Auth::user())) {
            flash(trans('reservations.success_deleted'))->success();
        } else {
            flash(trans('general.unsuccessful'))->error();
        }
        return redirect()->back();


    }
}
