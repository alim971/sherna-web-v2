<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryCategory;
use App\Models\Inventory\InventoryItem;
use App\Models\Language\Language;
use App\Models\Locations\Location;
use DB;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::orderBy('name', 'asc')->paginate(20);

        return view('admin.inventory.index', ['inventoryItems' => $inventoryItems]);
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function edit($id)
    {
        $inventoryItem = InventoryItem::where('id', $id)->first();

        return view('admin.inventory.edit', ['inventoryItem' => $inventoryItem]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name-1' => 'required|string|max:255',
            'category_id' => 'required',
            'serial_id' => '',
            'inventory_id' => '',
            'location_id' => 'required',
        ]);

        $category = InventoryCategory::where('id', $request->get('category_id'))->firstOrFail();
        $location = Location::where('id', $request->get('location_id'))->firstOrFail();
        $next_id = DB::table('inventory_items')->max('id') + 1;
        foreach (Language::all() as $language) {
            $item = new InventoryItem();
            $item->id = $next_id;
            $item->name = $request->get('name-' . $language->id);
            $item->serial_id = $request->get('serial_id');
            $item->inventory_id = $request->get('inventory_id');
            $item->note = $request->get('note');
            $item->language()->associate($language);
            $item->category()->associate($category);
            $item->location()->associate($location);
            $item->save();
        }

        flash()->success('Inventory item successfully created');

        return redirect()->route('inventory.index');
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'name-1' => 'required|string|max:255',
            'category_id' => 'required',
            'serial_id' => '',
            'inventory_id' => '',
            'location_id' => 'required',
        ]);
        $category = InventoryCategory::where('id', $request->get('category_id'))->firstOrFail();
        $location = Location::where('id', $request->get('location_id'))->firstOrFail();
        foreach (Language::all() as $language) {
            $item = InventoryItem::where('id', $id)->ofLang($language)->firstOrFail();
            $item->name = $request->get('name-' . $language->id);
            $item->serial_id = $request->get('serial_id');
            $item->inventory_id = $request->get('inventory_id');
            $item->note = $request->get('note');
            $item->category()->associate($category);
            $item->location()->associate($location);
            $item->save();
        }


        flash()->success('Inventory item successfully updated');

        return redirect()->route('inventory.index');
    }

    public function destroy($id)
    {
        foreach (Language::all() as $language) {
            $inventoryItem = InventoryItem::where('id', $id)->ofLang($language);
            $inventoryItem->delete();

        }
        flash()->success('Inventory item successfully deleted');

        return redirect()->route('inventory.index');
    }
}
