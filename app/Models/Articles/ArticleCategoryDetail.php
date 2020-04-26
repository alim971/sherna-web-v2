<?php

namespace App\Models\Articles;


use App\Models\Extensions\LanguageModel;

class ArticleCategoryDetail extends LanguageModel
{
    protected $table = 'article_categories_details';

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }
}
