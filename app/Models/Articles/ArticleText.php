<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleText extends LanguageModel
{
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles_text';

    public function page()
    {
        return $this->belongsTo(Article::class, 'url'); //id?
    }
}
