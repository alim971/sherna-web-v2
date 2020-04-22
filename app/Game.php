<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name', 'note', 'console_id', 'possible_players', 'serial_id',
        'inventory_id', 'vr', 'move', 'kinect', 'game_pad', 'guitar'
    ];

    public function console() {
        return $this->belongsTo(Console::class);
    }
}
