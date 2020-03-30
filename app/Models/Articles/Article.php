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

    protected $dates = ['deleted_at'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function texts()
    {
        return $this->hasMany(ArticleText::class, 'url', 'url');
    }

    public function textsOfLang($lang)
    {
        return $this->hasMany(ArticleText::class, 'url', 'url')
                    ->where('language_id', $lang->id)
                    ->withoutGlobalScope(LanguageScope::class);
    }

    public function allTexts()
    {
        return $this->hasMany(ArticleText::class, 'url', 'url')
            ->withoutGlobalScope(LanguageScope::class);
    }

    public function getRouteKeyName()
    {
        return 'url';
    }
}
