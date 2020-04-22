<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{

    use SoftDeletes;

    protected $dates = ['start', 'end', 'entered_at'];

    //
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function location() {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function duration() {

        return $this->end->floatDiffInHours($this->start);
    }

    public function scopeActiveReservation( $query )
    {
        return $query->where(function ( $q ) {
            $q->where('start', '<=', date('Y-m-d H:i:s'))->where('end', '>=', date('Y-m-d H:i:s'));
        });
    }

    public function scopeFutureReservations( $query )
    {
        return $query->where(function ( $q ) {
            $q->where('start', '>=', date('Y-m-d H:i:s'));
        });
    }

    public function scopeFutureActiveReservations( $query )
    {
        return $query->where(function ( $q ) {
            $q->where('start', '>=', date('Y-m-d H:i:s'))->orWhere(function ($q) {
                $q->where('start', '<=', date('Y-m-d H:i:s'))->where('end', '>=', date('Y-m-d H:i:s'));
            });
        });
    }
}
