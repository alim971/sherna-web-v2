<?php


namespace App\Http\Services;

use App\Http\Scopes\LanguageScope;
use App\Location;
use App\LocationStatus;
use App\Permission;
use App\Reservation;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    public function makeReservation($request, $user) {
        $reservation = $this->createReservation($request, $user);
        if($this->validate($user, $reservation)) {
            $reservation->save();
        } else {
            return false;
        }
        return true;
    }

    public function updateReservation($request, Reservation $reservation, User $user) {
        $this->update($request, $reservation);
        if($this->validate($user, $reservation, true)) {
                $reservation->save();
        } else {
            return false;
        }
        return true;
    }

    public function deleteReservation(Reservation $reservation, User $user) {
        if($this->validate($user, $reservation)) {
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
            return false;
        } else if($this->overlap($reservation) > 0) {
            return false;
        }
        return true;
    }

    private function validateForUser( $user, Reservation $reservation) {
        $closed = LocationStatus::where('status', 'Closed')->withoutGlobalScope(LanguageScope::class)->firstOrFail()
            ->id;
        if($user->reservations) {
            return false;
        } else if($reservation->duration() > Setting::where('name', 'duration')) {
            return false;
        } else if($reservation->duration() <= 0) {
            return false;
        } else if($reservation->location->status->id == $closed) {
            return false;
        } else if($reservation->vr) {
            $permission = Permission::where('name', 'VR');
            if(!$user->role->hasPermission($permission))
                return false;
        } else if($this->overlap($reservation > 0)) {
            return false;
        }
        return true;
    }

    private function overlap($reservation) {
        $start = $reservation->start;
        $end = $reservation->end;
        $rangeCount = Reservation::where('location_id', $reservation->location_id)->where(function ($query) use ($start, $end) {
            $query->where(function ($query) use ($start, $end) {
                $query->where('start', '<=', $start)
                    ->where('end', '>', $start);
            })->orWhere(function ($query) use ($start, $end) {
                $query->where('start', '<', $end)
                    ->where('end', '>=', $end);
            })->orWhere(function ($query) use ($start, $end) {
                $query->where('start', '>=', $start)
                    ->where('end', '<=', $end);
            })->orWhere(function ($query) use ($start, $end) {
                $query->where('start', '<=', $start)
                    ->where('end', '>=', $end);
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
        $location = Location::where('id' , $request->get('location'))->firstOrFail();
        $reservation->location()->associate($location);
        $reservation->start = Carbon::createFromFormat('d.m.Y - H:i', $request->get('start'));
        $reservation->end = Carbon::createFromFormat('d.m.Y - H:i', $request->get('end'));
        $reservation->vr = $request->get('vr', false) ? 1 : 0;
        return $reservation;
    }

    private function validateUpdate(User $user, Reservation $reservation)
    {

        $validation = $this->validateForUser($user, $reservation);
        if(!$validation) {
            return false;
        }
        if($reservation->getOriginal('start')->minusMinutes(15)->isPast()) {
            if($reservation->start != $reservation->getOriginal('start')) {
                return false;
            }
            if($reservation->location_id != $reservation->getOriginal('location_id')) {
                return false;
            }
        }
        return true;
    }
}
