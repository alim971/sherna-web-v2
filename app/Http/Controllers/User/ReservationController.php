<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\ReservationService;
use App\Reservation;
use Carbon\Carbon;
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
        $reservations = Reservation::where('location_id', $request->get('location'))->get(['id', 'start', 'end', 'visitors_count', 'location_id', 'note', 'user_id']);
        foreach ($reservations as $reservation) {
            $owner = $reservation->user;

            $reservation->title = trans('reservations.reservation_for') . $owner->name . ' ' . $owner->surname;


            if (Auth::check() && $reservation['user_id'] == Auth::user()->id) {
                $reservations->editable = !$reservation->start->addMinutes(-1 * 10)->isPast();
            }
        }

        return Response::json($reservations);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::latest()->paginate();
        return view('reservation.index', ['reservations' => $reservations]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reservation.create')->render();
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

        return redirect()->route('reservation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        return view('reservation.edit')->render();
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
        return redirect()->route('reservation.index');

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
        return redirect()->route('reservation.index');


    }
}
