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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Class handling CRUD operations on Article Model,
 * handling also publishing (make public) of articles
 *
 * Class ArticleController
 * @package App\Http\Controllers\Admin
 */
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View    index page listing all the articles paginated
     */
    public function index()
    {
        $articles = Article::latest()->paginate();
        return view('admin.blog.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new Article
     *
     * @return View view with the create form for Article
     */
    public function create()
    {
        return view('admin.blog.articles.create', ['category' => null]);
    }

    /**
     * Show the form for creating a new Article with prefilled Article Category.
     *
     * @return View view with the create form for Article with prefilled Article Category
     */
    public function createWithCategory(string $category)
    {
        return view('admin.blog.articles.create', ['category' => $category . ' ']);
    }

    /**
     * Store a newly created Article in database.
     *
     * Save main article instance, then create a text for the article in every language
     *
     * @param StoreRequest $request     request with data from creation form
     * @return RedirectResponse         redirect to index page
     */
    public function store(StoreRequest $request)
    {
        $article = $this->saveArticle($request);
        foreach (Language::all() as $lang) {
            $this->saveArticleText($request, $article, $lang);
        }

        flash('Article successfully created')->success();
        return redirect()->route('article.index');
    }

    /**
     * Show the form for editing the Article
     *
     * @param Article $article   Article that will be edited
     * @return View              view with edition form
     */
    public function edit(Article $article)
    {
        return view('admin.blog.articles.edit', [
            'article' => $article,
        ]);
    }

    /**
     * Update the Article in database.
     *
     * First get the difference between existing categories and the categories that the updated article should
     * contain.
     * Then update the texts for all languages
     *
     * @param UpdateRequest $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Article $article)
    {
        //First get the difference between existing categories and the categories that the updated article should
        //contain
        $categories = $this->getCategories($request->get('tags', '') ?? '');
        $originalCategories = $article->categories()->pluck('id')->toArray();
        $article->categories()->detach(array_diff($originalCategories, $categories));
        $article->categories()->attach(array_diff($categories, $originalCategories));

        foreach (Language::all() as $lang) {
            $article->public = $request->get('public') ? 1 : 0;
            $text = $article->text()->ofLang($lang)->first();
            $text->title = $request->input('name-' . $lang->id);
            $text->description = $request->input('description-' . $lang->id);
            $text->content = $request->input('content-' . $lang->id);
            $text->save();
        }
        $article->save();
        flash('Article successfully updated')->success();
        return redirect()->route('article.index');

    }

    /**
     * Remove the Article from database.
     *
     * @param Article $article
     * @return Response
     */
    public function destroy(Article $article)
    {
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
     * Make the article public/not public, depending on the previous state
     *
     * @param Article $article  Article that should be public/private
     * @return RedirectResponse show the index view
     */
    public function public(Article $article)
    {
        $article->public = !$article->public;
        $article->save();
        flash("Article is now " . ($article->public ? "public" : "hidden"))->success();
        return redirect()->route('article.index');
    }

    /**
     * Create and save the article
     *
     * @param StoreRequest $request  request with all the data needed to create an Article
     * @return Article
     */
    private function saveArticle(StoreRequest $request)
    {
        $article = new Article();
        $article->url = $request->input('url');
        $article->public = $request->get('public') ? 1 : 0;
        $categories = $this->getCategories($request->get('tags', '') ?? '');
        $article->user()->associate(Auth::user());
        $article->save();
        $article->categories()->attach($categories);
        return $article;
    }

    /**
     * Get all the categories from string
     * If category doesn't exists, create it
     *
     * @param string $categories  string containing all the categories of article, every
     *                            category is separated by space
     * @return array              array containing all the categories article should contain
     */
    private function getCategories(string $categories)
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
                $result[] = $this->createCategory($tag)->id;
            }
        }
        return $result;
    }

    /**
     * Create a new category
     *
     * @param string $name  name of the new Category
     * @return ArticleCategory
     */
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

}
