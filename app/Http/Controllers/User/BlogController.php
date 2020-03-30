<?php

namespace App\Http\Controllers\User;

use App\ArticleText;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

class BlogController extends Controller
{
    //Add Article Service

    /**
     * Show the about blog category requested
     *
     * @param string $url   part of url with the name of the category
     * @return Factory|View requested view
     */
    public function show(string $url)
    {
        //TODO IF blog categories contains $url
        //TODO show newest articles, use ArticleService, eg. ArticleService.getCategory($url).getLatest(

        return view('blog.' . $url);
    }

    /**
     * Show the about page that was requested
     *
     * @return Factory|View requested view
     */
    public function index()
    {
        //TODO show newest articles, use ArticleService, eg. ArticleService.getLatest(10);
        $articles = ArticleText::latest()->paginate();
        return view('article.index', ['articles' => $articles]);
        //return view('blog.index');
    }
}
