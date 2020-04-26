<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\JSON\AutocompleteModel;
use App\Models\Articles\ArticleCategory;
use App\Models\Articles\ArticleCategoryDetail;
use App\Models\Language\Language;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = ArticleCategory::paginate();
        return view('admin.blog.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $category = new ArticleCategory();
        $category->save();

        foreach (Language::all() as $language) {
            $detail = new ArticleCategoryDetail();
            $detail->name = $request->get('name-' . $language->id);
            $detail->language()->associate($language);
            $detail->category()->associate($category);
            $detail->save();
        }

        flash('Category was successfully created.')->success();
        return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ArticleCategory $category
     * @return Response
     */
    public function edit(ArticleCategory $category)
    {
        return view('admin.blog.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ArticleCategory $articleCategory
     * @return Response
     */
    public function update(Request $request, ArticleCategory $category)
    {
        foreach (Language::all() as $language) {
            $detail = $category->detail()->ofLang($language)->get()->first();
            $detail->name = $request->get('name-' . $language->id);
            $detail->save();
        }

        flash('Category was successfully updated.')->success();
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ArticleCategory $category
     * @return Response
     */
    public function destroy(ArticleCategory $category)
    {
        try {
            $category->delete();
        } catch (Exception $exception) {
            flash("Deletion of category was not successful.")->error();
            return redirect()->back();
        }

        flash('Category was successfully deleted.')->success();
        return redirect()->route('category.index');
    }

    public function auto()
    {
        return $this->autocomplete($_GET['term']);
    }

    private function autocomplete(string $term)
    {

        $categories = ArticleCategoryDetail::where('name', 'like', "%$term%")
            ->get()->pluck('name');
        $res = '';
        foreach ($categories as $category) {
            $jsonModel = new AutocompleteModel($category, $category);
            $res .= $jsonModel->getJSON();
        }
        return "[$res]";
    }
}
