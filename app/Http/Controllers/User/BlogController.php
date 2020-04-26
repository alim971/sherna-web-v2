<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Articles\Article;
use App\Models\Articles\ArticleCategory;
use App\Models\Navigation\Page;
use Illuminate\View\Factory;
use Illuminate\View\View;

class BlogController extends Controller
{
    //Add Article Service

    /**
     * Show the about blog category requested
     *
     * @param string $url part of url with the name of the category
     * @return Factory|View requested view
     */
    public function show(string $url)
    {
        //TODO IF blog categories contains $url
        //TODO show newest articles, use ArticleService, eg. ArticleService.getCategory($url).getLatest(

//        $article = Article::where('url', $url)->public()->firstOrFail();
        $article = Article::where('url', $url)->firstOrFail();
        return view('client.blog.show', ['article' => $article]);
    }

    /**
     * Show the about page that was requested
     *
     * @return Factory|View requested view
     */
    public function index()
    {
        if (!Page::where('special_code', 'blog')->firstOrFail()->public) {
            abort(404);
        }
        //TODO show newest articles, use ArticleService, eg. ArticleService.getLatest(10);
        $articles = Article::latest()->paginate();
        return view('client.blog.index', ['articles' => $articles]);
        //return view('blog.index');
    }

    /**
     * Show the about page that was requested
     *
     * @return Factory|View requested view
     */
    public function categories()
    {
//        if(!SubPage::where('url', 'categories')->firstOrFail()->public) {
//            abort(404);
//        }
        if (!Page::where('special_code', 'blog')->firstOrFail()->public) {
            abort(404);
        }
        $categories = ArticleCategory::paginate();
        //TODO show newest articles, use ArticleService, eg. ArticleService.getLatest(10);
        return view('client.blog.categories', ['categories' => $categories]);
        //return view('blog.index');
    }

}
