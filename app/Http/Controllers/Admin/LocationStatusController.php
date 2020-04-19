<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Language;
use App\LocationStatus;
use Illuminate\Http\Request;

class LocationStatusController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.locations.status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name-1' => 'required|string|max:255',
            'name-2' => 'required|string|max:255',
            'opened' => 'required',
        ]);

        $next_id = \DB::table('locations')->max('id') + 1;
        $opened = $request->input('opened');
        foreach (Language::all() as $lang) {
            $status = new LocationStatus();
            $status->id = $next_id;
            $status->name = $request->input('name-' . $lang->id);
            $status->opened = $opened;
            $status->language()->associate($lang);
            $status->save();
        }
        flash()->message('Location status successfully created')->success();
        return redirect()->route('location.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = LocationStatus::where('id', $id)->firstOrFail();
        return view('admin.locations.status.edit', ['status' => $status]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'name-1' => 'required|string|max:255',
            'name-2' => 'required|string|max:255',
            'opened' => 'required',
        ]);
        $opened = $request->input('opened');

        foreach (Language::all() as $lang) {
            $status = LocationStatus::where('id', $id)->ofLang($lang)->firstOrFail();
            $status->name = $request->input('name-' . $lang->id);
            $status->opened = $opened;
            $status->save();
        }
        flash()->message('Location status successfully updated')->success();

        return redirect()->route('location.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        foreach (Language::all() as $lang) {
            try {
                $status = LocationStatus::where('id', $id)->ofLang($lang)->firstOrFail();
                $status->delete();
            } catch (\Exception $exception) {
                flash()->message('Location status not deleted')->error();
                return redirect()->back();
            }
        }
        flash()->message('Location status deleted successfully')->success();

        return redirect()->route('locations.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = LocationStatus::latest()->paginate();
        return view('location_status.index', ['statuses' => $statuses]);
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        return view('location_status.create');
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        $next_id = \DB::table('location_statuses')->max('id') + 1;
//        foreach (Language::all() as $lang) {
//            $loc = new LocationStatus();
//            $loc->id = $next_id;
//            $loc->status = $request->input('status-' . $lang->id);
//            $loc->language()->associate($lang);
//            $loc->save();
//        }
//
//        return redirect()->route('status.index');
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show(int $id)
//    {
//        $status = LocationStatus::where('id', $id)->firstOrFail();
//        return view('location_status.show', ['status' => $status]);
//
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(int $id)
//    {
//        $status = LocationStatus::where('id', $id)->firstOrFail();
//        return view('location_status.edit', ['status' => $status]);
//
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, int $id)
//    {
//        foreach (Language::all() as $lang) {
//            $loc =  LocationStatus::where('id', $id)->ofLang($lang)->firstOrFail();
//            $loc->status = $request->input('status-' . $lang->id);
//            $loc->save();
//        }
//
//        return redirect()->route('status.index');
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param int $id
//     * @return void
//     */
//    public function destroy(int $id)
//    {
//        foreach (Language::all() as $lang) {
//            try {
//                $status = \App\LocationStatus::where('id', $id)->ofLang($lang)->firstOrFail();
//                $status->delete();
//
//            } catch (\Exception $exception) {
//                return redirect()->back()->withErrors(["Nedošlo k odstránenie"]);
//            }
//        }
//        return redirect()->route('status.index');
//    }
//}
}
