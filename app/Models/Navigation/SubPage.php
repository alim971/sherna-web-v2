<?php

namespace App\Models\Navigation;

use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Extensions\LanguageModel;

class SubPage extends LanguageModel
{

    use CompositePrimaryKeyTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_subpages';
    protected $primaryKey = ['id', 'language_id'];

    public function text()
    {
        return $this->hasOne(SubPageText::class, 'nav_subpage_id', 'id');
    }


    public function page()
    {
        return $this->belongsTo(Page::class, 'nav_page_id', 'id');
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
