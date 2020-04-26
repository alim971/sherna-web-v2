<?php

namespace App\Models\Inventory;


use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;
use App\Models\Locations\Location;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends LanguageModel
{
    use CompositePrimaryKeyTrait, SoftDeletes;

    protected $primaryKey = ['id', 'language_id'];


    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
