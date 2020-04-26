<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language\Language;
use App\Models\Locations\Location;
use App\Models\Locations\LocationStatus;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $locations = Location::latest()->paginate();
        $statuses = LocationStatus::latest()->paginate();
        return view('admin.locations.index', ['locations' => $locations,
            'statuses' => $statuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.locations.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $next_id = DB::table('locations')->max('id') + 1;
        $status = LocationStatus::where('id', $request->input('status'))->firstOrFail();
        $uid = $request->input('location_id');
        $reader = $request->input('reader_uid');
        foreach (Language::all() as $lang) {
            $loc = new Location();
            $loc->id = $next_id;
            $loc->location_uid = $uid;
            $loc->reader_uid = $reader;
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
     * @return Response
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
     * @return Response
     */
    public function edit(int $id)
    {
        $location = Location::where('id', $id)->firstOrFail();

        return view('admin.locations.edit', ['location' => $location]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $status = LocationStatus::where('id', $request->input('status'))->firstOrFail();
        $uid = $request->input('location_id');
        $reader = $request->input('reader_uid');
        foreach (Language::all() as $lang) {
            $location = Location::where('id', $id)->ofLang($lang)->firstOrFail();
            $location->name = $request->input('name-' . $lang->id);
            $location->location_uid = $uid;
            $location->reader_uid = $reader;
            $location->status()->associate($status);
            $location->save();
        }

        flash("Successfully updated.")->success();
        return redirect()->route('location.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        foreach (Language::all() as $lang) {
            try {
                $location = Location::where('id', $id)->ofLang($lang)->firstOrFail();
                $location->delete();
            } catch (Exception $exception) {
                flash("Deletion was unsuccessful.")->error();
                return redirect()->back();
            }
        }
        flash("Deletion was successful.")->success();

        return redirect()->route('location.index');
    }
}
