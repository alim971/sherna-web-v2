<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryCategory;
use App\Models\Language\Language;
use DB;
use Illuminate\Http\Request;

class InventoryCategoryController extends Controller
{
    public function index()
    {
        $inventoryCategories = InventoryCategory::paginate(20);

        return view('admin.inventory.category.index', ['inventoryCategories' => $inventoryCategories]);
    }

    public function create()
    {

        return view('admin.inventory.category.create');
    }

    public function edit($id)
    {
        $inventoryCategory = InventoryCategory::where('id', $id)->first();

        return view('admin.inventory.category.edit', ['inventoryCategory' => $inventoryCategory]);
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (Language::all() as $language) {
            $rules['name-' . $language->id] = 'required|string|max:255';
        }
        $this->validate($request, $rules);
        $next_id = DB::table('inventory_categories')->max('id') + 1;
        foreach (Language::all() as $language) {
            $category = new InventoryCategory();
            $category->id = $next_id;
            $category->name = $request->get('name-' . $language->id);
            $category->language()->associate($language);
            $category->save();
        }

        flash()->success('Inventory category successfully created');

        return redirect()->route('inventory.category.index');
    }

    public function update($id, Request $request)
    {
        $rules = [];
        foreach (Language::all() as $language) {
            $rules['name-' . $language->id] = 'required|string|max:255';
        }
        $this->validate($request, $rules);

        foreach (Language::all() as $language) {
            $category = InventoryCategory::where('id', $id)->ofLang($language)->first();
            $category->name = $request->get('name-' . $language->id);
            $category->save();
        }

        flash()->success('Inventory category successfully updated');

        return redirect()->route('inventory.category.index');

    }

    public function destroy($id)
    {
        foreach (Language::all() as $language) {
            $inventoryCategory = InventoryCategory::ofLang($language)->where('id', $id)->first();
            $inventoryCategory->delete();
        }

        flash()->success('Inventory category successfully deleted');

        return redirect()->route('inventory.category.index');
    }
}
