<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Article::updateOrInsert([
            'id' => 1,
            'user_id' => 30542,
            'url' => 'uvod',
            'public' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ]);

        \App\ArticleText::updateOrInsert([
            'id' => 1,
            'article_id' => 1,
            'title' => 'Uvod',
            'description' => 'Uvodna stranka',
            'content' => '<p>Vítejte na našem webu!</p><p>Tento web je postaven na <strong>jednoduchém redakčním
systému v Laravel frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'language_id' => 1,
        ]);
        \App\ArticleText::updateOrInsert([
            'id' => 2,
            'article_id' => 1,
            'title' => 'Welcome',
            'description' => 'Welcome page',
            'content' => '<p>Welcome</p><p>Tento web je postaven na <strong>jednoduchém redakčním
systému v Laravel frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'language_id' => 2,
        ]);

        \App\ArticleCategory::updateOrInsert([
            'id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\ArticleCategoryDetail::updateOrInsert([
            'id' => 1,
            'category_id' => 1,
            'name' => 'Hry',
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\ArticleCategoryDetail::updateOrInsert([
            'id' => 2,
            'category_id' => 1,
            'name' => 'Games',
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $article = \App\Article::first();
        $category = \App\ArticleCategory::first();
        $article->categories()->attach($category);
        $article->save();
//
//        \App\ArticleText::updateOrInsert([
//            'id' => 1,
//            'article_id' => 1,
//            'title' => 'Uvod',
//            'description' => 'Uvodna stranka',
//            'content' => '<p>Vítejte na našem webu!</p><p>Tento web je postaven na <strong>jednoduchém redakčním
//systému v Laravel frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>',
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//            'language_id' => 1,
//        ]);
//        \App\ArticleText::updateOrInsert([
//            'id' => 2,
//            'article_id' => 1,
//            'title' => 'Welcome',
//            'description' => 'Welcome page',
//            'content' => '<p>Welcome</p><p>Tento web je postaven na <strong>jednoduchém redakčním
//systému v Laravel frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>',
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//            'language_id' => 2,
//        ]);
    }
}
