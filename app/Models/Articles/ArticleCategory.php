<?php

namespace App\Models\Articles;


use App\Http\Scopes\LanguageScope;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    //
    use CascadeSoftDeletes, SoftDeletes;

    protected $cascadeDeletes = ['details'];


    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category', 'category_id', 'article_id');
    }

    public function detail()
    {
        return $this->hasOne(ArticleCategoryDetail::class, 'category_id');
    }

    public function details()
    {
        return $this->hasMany(ArticleCategoryDetail::class, 'category_id')
            ->withoutGlobalScope(LanguageScope::class);
    }
}
