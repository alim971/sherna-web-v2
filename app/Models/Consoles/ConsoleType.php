<?php

namespace App\Models\Consoles;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsoleType extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['consoles'];
    protected $fillable = [
        'name'
    ];

    public function consoles()
    {
        return $this->hasMany(Console::class);
    }
}
