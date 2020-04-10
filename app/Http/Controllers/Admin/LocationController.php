<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Language;
use App\Location;
use App\LocationStatus;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::latest()->paginate();
        return view('location.index', ['locations' => $locations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('location.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $next_id = \DB::table('locations')->max('id') + 1;
        $status = LocationStatus::where('id', $request->input('status'))->firstOrFail();
        foreach (Language::all() as $lang) {
            $loc = new Location();
            $loc->id = $next_id;
            $loc->name = $request->input('name-' . $lang->id);
            $loc->status()->associate($status);
            $loc->language()->associate($lang);
            $loc->save();
        }

        return redirect()->route('location.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $location = Location::where('id', $id)->firstOrFail();

        return view('location.show', ['location' => $location]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $location = Location::where('id', $id)->firstOrFail();
        return view('location.edit', ['location' => $location]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = LocationStatus::where('id', $request->input('status'))->firstOrFail();
        foreach (Language::all() as $lang) {
            $location = \App\Location::where('id', $id)->ofLang($lang)->firstOrFail();
            $location->name = $request->input('name-' . $lang->id);
            $location->status()->associate($status);
            $location->save();
        }

        return redirect()->route('location.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        foreach (Language::all() as $lang) {
            try {
                $location = \App\Location::where('id', $id)->ofLang($lang)->firstOrFail();
                $location->delete();
            } catch (\Exception $exception) {
                return redirect()->back()->withErrors(["Nedošlo k odstránenie"]);
            }
        }

        return redirect()->route('location.index');
    }
}
