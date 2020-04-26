<?php

namespace App\Models\Locations;

use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationStatus extends LanguageModel
{

    use SoftDeletes, CascadeSoftDeletes, CompositePrimaryKeyTrait;

    protected $primaryKey = ['id', 'language_id'];

    protected $cascadeDeletes = ['locations'];


    public function locations()
    {
        return $this->hasMany(Location::class, 'status_id', 'id');
    }
}
