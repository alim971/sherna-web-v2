<?php

namespace App\Nav;

use App\Http\Scopes\LanguageScope;
use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Language;
use App\LanguageModel;
use App\Nav\PageText;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends LanguageModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nav_pages';

    use CompositePrimaryKeyTrait;

    protected $primaryKey = ['id', 'language_id'];
    public $incrementing = false;

    public $timestamps = true;

    public function subpages() {
        return $this->hasMany(SubPage::class, 'nav_page_id', 'id');
    }

    public function text()
    {
        return $this->hasOne(PageText::class, 'nav_page_id', 'id');
    }

    public function scopePublic( $query )
    {
        return $query->where(function ( $q ) {
            $q->where('public', true);
        });
    }

    public function getRouteKeyName()
    {
        return 'url';
    }



}
