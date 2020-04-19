<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    //

    public function articles() {
        return $this->belongsToMany(Article::class, 'article_category', 'article_id', 'category_id');
    }

    public function detail() {
        return $this->hasOne(ArticleCategoryDetail::class, 'category_id');
    }
}
