<?php

namespace App\Models\Navigation;

use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;

class Page extends LanguageModel
{

    public $incrementing = false;

    use CompositePrimaryKeyTrait;
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_pages';
    protected $primaryKey = ['id', 'language_id'];

    public function subpages()
    {
        return $this->hasMany(SubPage::class, 'nav_page_id', 'id');
    }

    public function text()
    {
        return $this->hasOne(PageText::class, 'nav_page_id', 'id');
    }

    public function scopePublic($query)
    {
        return $query->where(function ($q) {
            $q->where('public', true);
        });
    }

    public function getRouteKeyName()
    {
        return 'url';
    }


}
