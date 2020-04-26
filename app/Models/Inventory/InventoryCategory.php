<?php

namespace App\Models\Inventory;

use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryCategory extends LanguageModel
{
    use CompositePrimaryKeyTrait, SoftDeletes, CascadeSoftDeletes;

    protected $primaryKey = ['id', 'language_id'];

    protected $cascadeDeletes = ['items'];


    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'category_id', 'id');
    }
}
