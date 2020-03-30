<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
