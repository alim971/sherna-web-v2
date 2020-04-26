<?php

namespace App\Models\Consoles;

use App\Models\Games\Game;
use App\Models\Locations\Location;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Console extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'console_type_id',
        'location_id'
    ];

    protected $cascadeDeletes = ['games'];


    public function type()
    {
        return $this->belongsTo(ConsoleType::class, 'console_type_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');

    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
