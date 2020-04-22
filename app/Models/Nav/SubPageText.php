<?php

namespace App\Nav;

use App\Http\Scopes\LanguageScope;
use App\Language;
use App\LanguageModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubPageText extends LanguageModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_subpages_text';

    public function page()
    {
        return $this->belongsTo(SubPage::class, 'nav_subpage_id', 'id');
    }


    public function getRouteKeyName()
    {
        return 'url';
    }

}
