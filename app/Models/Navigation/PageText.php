<?php

namespace App\Models\Navigation;


use App\Models\Extensions\LanguageModel;

class PageText extends LanguageModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_pages_text';


    public function page()
    {
        return $this->belongsTo(Page::class, 'nav_page_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'url';
    }

}
