<?php

namespace App\Nav;

use App\Http\Scopes\LanguageScope;
use App\LanguageModel;
use App\Nav\PageText;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends LanguageModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_pages';

    public function pageText()
    {
        return $this->hasMany(PageText::class, 'nav_page_id');
    }

    public function allPageTexts()
    {
        return $this->hasMany(PageText::class, 'nav_page_id')
            ->withoutGlobalScope(LanguageScope::class);
    }
}
