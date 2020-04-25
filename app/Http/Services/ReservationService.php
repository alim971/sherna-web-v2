<?php


namespace App\Http\Services;

use App\Http\Scopes\LanguageScope;
use App\Location;
use App\LocationStatus;
use App\Permission;
use App\Reservation;
use App\Setting;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationService
{

    public function getReservation(int $perPage = 15) {
        return Reservation::latest()->paginate($perPage);
    }

    public function getAllReservation(int $perPage = 15) {
        return Reservation::withTrashed()->latest()->paginate($perPage);
    }

    public function makeReservation($request, $user) {
        $reservation = $this->createReservation($request, $user);
        $validation = $this->validate($user, $reservation);
        if(!is_string($validation)) {
            $reservation->save();
        } else {
            return $validation;
        }
        return true;
    }

    public function updateReservation($request, Reservation $reservation, User $user) {
        $this->update($request, $reservation);
        $validation = $this->validate($user, $reservation, true);
        if(!is_string($validation)) {
                $reservation->save();
        } else {
            return $validation;
        }
        return true;
    }

    public function deleteReservation(Reservation $reservation, User $user) {
        if(!is_string($this->validate($user, $reservation, true))) {
            $reservation->delete();
        } else {
            return false;
        }
        return true;
    }

    private function validate(User $user, Reservation $reservation, $update = false) {
        $permission = Permission::where('name', 'Reservation Manager')->firstOrFail();
        if($user->role->hasPermission($permission)) {
            return $this->validateForAdmin($reservation);
        } else {
            return $update ? $this->validateUpdate($user, $reservation) : $this->validateForUser($user, $reservation);
        }
    }

    private function validateForAdmin(Reservation $reservation) {
        if($reservation->duration() <= 0) {
            return trans('reservations.too_short');
        } else if($this->overlap($reservation) > 0) {
            return trans('reservations.overlap');
        } else if($reservation->visitors_count < 0) {
            return trans('reservations.minimal_visitor');
        } else if($reservation->start_at->isBefore(Carbon::now()
            ->addMinutes(Setting::where('name', 'Time for edit')->first()->value))) {
            return trans('reservations.in_past');
        }
        return true;
    }

    private function validateForUser( $user, Reservation $reservation) {
        $maxReservations = $reservation->exists ? 1 : 0;
        if($user->reservations()->futureReservations()->count() > $maxReservations) {
            return trans('reservations.too_many');
        } else if($reservation->duration() > Setting::where('name', 'Maximal Duration')->first()->value) {
            return trans('reservations.too_long');
        } else if($reservation->start_at->isAfter(Carbon::now()->addDays(Setting::where('name', 'Reservation Area')->first()->value))){
            return trans('reservations.too_far');
        } else if(!$reservation->location->status->opened) {
            return trans('reservations.closed');
        } else if($reservation->vr) {
            $permission = Permission::where('name', 'VR');
            if(!$user->role->hasPermission($permission))
                return trans('reservations.vr');
        } else {
            return $this->validateForAdmin($reservation);
        }
        return true;
    }

    private function overlap($reservation) {
        $start = $reservation->start_at;
        $end = $reservation->end_at;
        $rangeCount = Reservation::where('location_id', $reservation->location_id)
            ->where('id', '!=', $reservation->id)
            ->where(function ($query) use ($start, $end) {
            $query->where(function ($query) use ($start, $end) {
                $query->where('start_at', '<=', $start)
                    ->where('end_at', '>', $start);
            })->orWhere(function ($query) use ($start, $end) {
                $query->where('start_at', '<', $end)
                    ->where('end_at', '>=', $end);
            })->orWhere(function ($query) use ($start, $end) {
                $query->where('start_at', '>=', $start)
                    ->where('end_at', '<=', $end);
            })->orWhere(function ($query) use ($start, $end) {
                $query->where('start_at', '<=', $start)
                    ->where('end_at', '>=', $end);
            });
        })->count();
        if($rangeCount > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function createReservation($request, User $user) {
        $reservation = new Reservation();
        $reservation->user()->associate($user);
        $this->update($request, $reservation);
        return $reservation;
    }

    private function update($request, Reservation $reservation) {
        $location = Location::where('id' , $request->get('location_id'))->firstOrFail();
        $reservation->location()->associate($location);
        $reservation->visitors_count = $request->get('visitors_count', 1);
        $reservation->start_at = Carbon::createFromFormat('d.m.Y  H:i:s', $request->get('from_date'));
        $reservation->end_at = Carbon::createFromFormat('d.m.Y  H:i:s', $request->get('to_date'));
        $reservation->vr = $request->get('vr', false) ? 1 : 0;
        return $reservation;
    }

    private function validateUpdate(User $user, Reservation $reservation)
    {

        $validation = $this->validateForUser($user, $reservation);
        if(is_string($validation)) {
            return $validation;
        }
        if($reservation->getOriginal('start_at')->addMinutes(-15)->isPast()) {
            if($reservation->start_at != $reservation->getOriginal('start')) {
                return trans('reservations.change_start');
            }
            if($reservation->location_id != $reservation->getOriginal('location_id')) {
                return trans('reservations.change_location');
            }
        }
        return true;
    }
}
