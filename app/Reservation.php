<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    public function user() {
        return $this->hasOne(User::class);
    }

    public function location() {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }
}
