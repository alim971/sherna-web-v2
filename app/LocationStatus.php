<?php

namespace App;

use App\Http\Traits\CompositePrimaryKeyTrait;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationStatus extends LanguageModel
{

    use SoftDeletes, CascadeSoftDeletes, CompositePrimaryKeyTrait;

    protected $primaryKey = ['id', 'language_id'];
    public $incrementing = false;

    protected $cascadeDeletes = ['locations'];


    public function locations() {
        return $this->hasMany(Location::class, 'status_id', );
    }
}
