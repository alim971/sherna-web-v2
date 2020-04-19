<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{

    use SoftDeletes;

    protected $dates = ['start_at', 'end_at', 'entered_at'];

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
