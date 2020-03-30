<?php

namespace App;

use App\Http\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{

    use SoftDeletes, CascadeSoftDeletes;

    /**
     * Pole vlastností, které nejsou chráněné před mass assignment útokem.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'url', 'description', 'content',
    ];

    protected $cascadeDeletes = ['allTexts', 'comments'];

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function text()
    {
        return $this->hasOne(ArticleText::class);
    }

    public function textsOfLang($lang)
    {
        return $this->hasMany(ArticleText::class, )
                    ->where('language_id', $lang->id)
                    ->withoutGlobalScope(LanguageScope::class);
    }

    public function allTexts()
    {
        return $this->hasMany(ArticleText::class, )
            ->withoutGlobalScope(LanguageScope::class);
    }

    public function getRouteKeyName()
    {
        return 'url';
    }
}
