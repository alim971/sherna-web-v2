<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ReservationService;
use App\Models\Reservations\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reservations = $this->reservationService->getAllReservation();
        return view('admin.reservations.index', ['reservations' => $reservations]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.reservations.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->reservationService->makeReservation($request, Auth::user());

        return redirect()->route('admin.reservation.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function edit($id)
    {
        $reservation = Reservation::withTrashed()->where('id', $id)->first();
        return view('admin.reservations.edit', ['reservation' => $reservation])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reservation $reservation
     * @return Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->reservationService->updateReservation($request, $reservation, Auth::user());
        return redirect()->route('admin.reservation.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function destroy(Reservation $reservation)
    {
        $this->reservationService->deleteReservation($reservation, Auth::user());
        return redirect()->route('admin.reservation.index');


    }
}
