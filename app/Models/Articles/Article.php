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

    /**
     * Has One relation using global LanguageScope
     * Every article has only one text of current language
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function text()
    {
        return $this->hasOne(ArticleText::class);
    }

    /**
     * Has Many relation
     * Query without global LanguageScope
     * Every article has text for every language
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allTexts()
    {
        return $this->hasMany(ArticleText::class)
            ->withoutGlobalScope(LanguageScope::class);
    }

    public function getRouteKeyName()
    {
        return 'url';
    }
}
