<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    protected $dates = ['start', 'end'];

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
}
