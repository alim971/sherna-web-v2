<?php

namespace App\Nav;

use App\LanguageModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubPage extends LanguageModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_subpages';

    public function pageText()
    {
        return $this->hasMany(SubPageText::class, 'nav_subpage_id');
    }
}
