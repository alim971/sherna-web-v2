<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleText;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
//        $fullArticles = Article::latest()->join('articles_text', function ($join) {
//                $join->on('articles.url', '=', 'articles_text.url');
//            })->select('articles_text.*')
        $articles = Article::latest()->paginate();
        return view('article.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreRequest $request)
    {
        //
        //Article::create($request->all());
        $article = $this->saveArticle($request);
        foreach (Language::all() as $lang) {
            $this->saveArticleText($request, $article, $lang);
        }


        return redirect()->route('article.index');
    }

    private function saveArticle(StoreRequest $request) {
        $article = new Article();
        $article->url = $request->input('url');
        $this->setTimestampsToNow($article);
        $article->save();
        return $article;
    }

    private function saveArticleText(StoreRequest $request, Article $article, Language $lang) {
        $articleText = new ArticleText();
        $articleText->title = $request->input('title-' . $lang->id);
        $articleText->description = $request->input('description-' . $lang->id);
        $articleText->content = $request->input('content-' . $lang->id);
        $this->setTimestampsToNow($articleText);
//        $articleText->article_id = $article->id;
//        $articleText->url = $article->url;
        $articleText->page()->associate($article);
        $articleText->language()->associate($lang);
        $articleText->save();
    }

    private function setTimestampsToNow($model) {
        $model->created_at = Carbon::now();
        $model->updated_at = Carbon::now();
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return Response
     */
    public function show(Article $article)
    {
//        $article = Article::where('url', $url)->firstOrFail();
        return view('article.show', ['article' => $article->text()->first()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return Response
     */
    public function edit(Article $article)
    {
        //
//        $article = Article::where('url', $url)->firstOrFail();
        return view('article.edit', [
            'article' => $article,
            'texts' => $article->allTexts()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param Article $article
     * @return Response
     */
    public function update(UpdateRequest $request, Article $article)
    {
        //
        foreach ($article->allTexts()->get() as $text) {
            $lang = $text->language->id;
            $text->title = $request->input('title-' . $lang);
            $text->description = $request->input('description-' . $lang);
            $text->content = $request->input('content-' . $lang);
            $text->save();
        }
        $article->save();

        return redirect()->route('article.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return Response
     */
    public function destroy(Article $article)
    {
        //
        try {
            $article->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(["Nedošlo k odstránenie"]);
        }

        return redirect()->route('article.index');
    }
}
