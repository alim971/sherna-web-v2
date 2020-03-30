<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Pole vlastností, které nejsou chráněné před mass assignment útokem.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
