<?php

namespace App\Nav;

use App\Language;
use App\LanguageModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubPageText extends LanguageModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_subpages_text';

    public function page()
    {
        return $this->belongsTo(Page::class, 'nav_subpage_id');
    }

}
