<?php

namespace App\Http\Controllers\Admin;

use App\ArticleCategory;
use App\ArticleCategoryDetail;
use App\Http\Controllers\Controller;
use App\Http\JSON\AutocompleteModel;
use App\Language;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ArticleCategory::paginate();
        return view('admin.blog.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * @param  \App\ArticleCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticleCategory $category)
    {
        return view('admin.blog.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
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
     * @param  \App\ArticleCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $category)
    {
        try {
            $category->delete();
        } catch (\Exception $exception) {
            flash("Deletion of category was not successful.")->error();
            return redirect()->back();
        }

        flash('Category was successfully deleted.')->success();
        return redirect()->route('category.index');
    }

    public function auto() {
        return $this->autocomplete($_GET['term']);
    }

    private function autocomplete(string $term) {

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
