<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategoryDetail extends LanguageModel
{
    protected $table = 'article_categories_details';

    public function category() {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }
}
