<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Models\Articles\Article;
use App\Models\Articles\ArticleCategory;
use App\Models\Articles\ArticleCategoryDetail;
use App\Models\Articles\ArticleText;
use App\Models\Language\Language;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        return view('admin.blog.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('admin.blog.articles.create', ['category' => null]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createWithCategory(string $category)
    {
        return view('admin.blog.articles.create', ['category' => $category . ' ']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     * @throws ValidationException
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

    private function saveArticle(StoreRequest $request)
    {
        $article = new Article();
        $article->url = $request->input('url');
        $article->public = $request->get('public') ? 1 : 0;
        $categories = $this->getCategories($request->get('tags'));
        $article->user()->associate(Auth::user());
        $article->save();
        $article->categories()->attach($categories);
        return $article;
    }

    private function getCategories($categories)
    {
        $tags = explode(' ', trim($categories));
        $result = [];
        foreach ($tags as $tag) {
            if ($tag == '')
                continue;
            $check = ArticleCategoryDetail::where('name', $tag)->first();
            if($check) {
                $result[] = $check->category_id;
            } else {
                $result[] = $this->createCategory($tag);
            }
        }
        return $result;
    }

    private function createCategory(string $name) {
        $category = new ArticleCategory();
        $category->save();

        foreach (Language::all() as $language) {
            $detail = new ArticleCategoryDetail();
            $detail->name = $name;
            $detail->language()->associate($language);
            $detail->category()->associate($category);
            $detail->save();
        }
        return $category;
}

    private function saveArticleText(StoreRequest $request, Article $article, Language $lang)
    {
        $articleText = new ArticleText();
        $articleText->title = $request->input('name-' . $lang->id);
        $articleText->description = $request->input('description-' . $lang->id);
        $articleText->content = $request->input('content-' . $lang->id);
//        $articleText->article_id = $article->id;
//        $articleText->url = $article->url;
        $articleText->page()->associate($article);
        $articleText->language()->associate($lang);
        $articleText->save();
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
        return view('article.show', ['article' => $article]);
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
        return view('admin.blog.articles.edit', [
            'article' => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Article $article
     * @return Response
     */
    public function update(UpdateRequest $request, Article $article)
    {
        $categories = $this->getCategories($request->get('tags'));
        $originalCategories = $article->categories()->pluck('id')->toArray();
        $article->categories()->detach(array_diff($originalCategories, $categories));
        $article->categories()->attach(array_diff($categories, $originalCategories));
        foreach (Language::all() as $lang) {
            $article->public = $request->get('public') ? 1 : 0;
            $text = $article->text->ofLang($lang)->first();
            $text->title = $request->input('name-' . $lang->id);
            $text->description = $request->input('description-' . $lang->id);
            $text->content = $request->input('content-' . $lang->id);
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
        } catch (Exception $exception) {
            flash("Deletion of article was not successful.")->error();
            return redirect()->back();
        }

        flash("Article deleted sucesfully")->success();
        return redirect()->route('article.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return Response
     */
    public function public(Article $article)
    {
        $article->public = !$article->public;
        $article->save();
        flash("Article is now " . ($article->public ? "public" : "hidden"))->success();
        return redirect()->route('article.index');
    }

}
