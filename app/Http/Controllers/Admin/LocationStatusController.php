<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language\Language;
use App\Models\Locations\LocationStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class handling the CRUD operations on Location Status Model
 *
 * Class LocationStatusController
 * @package App\Http\Controllers\Admin
 */
class LocationStatusController extends Controller
{
    /**
     * Show the form for creating a new Location Status.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.locations.status.create');
    }

    /**
     * Store a newly created Location Status in database.
     *
     * @param Request $request request with all the data from creation form
     * @return RedirectResponse redirect to index page
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name-1' => 'required|string|max:255',
            'name-2' => 'required|string|max:255',
            'opened' => 'required',
        ]);

        $next_id = DB::table('location_statuses')->max('id') + 1;
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
     * Show the form for editing the specified Location Status.
     *
     * @param int $id   id of the specified Location Status to be edited
     * @return View     view with the edition form
     */
    public function edit($id)
    {
        $status = LocationStatus::where('id', $id)->firstOrFail();
        return view('admin.locations.status.edit', ['status' => $status]);


    }

    /**
     * Update the specified Location Status in storage.
     *
     * @param Request $request request with all the data from edition form
     * @param int $id id of the specified Location Status to be updated
     * @return RedirectResponse redirect to index page
     * @throws \Illuminate\Validation\ValidationException
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
     * Remove the specified Location Status from database
     *
     * @param int $id id of the specified Location to be deleted
     * @return RedirectResponse redirect to index page
     */
    public function destroy($id)
    {
        try {
            foreach (Language::all() as $lang) {

                $status = LocationStatus::where('id', $id)->ofLang($lang)->firstOrFail();
                $status->delete();
            }
            flash()->message('Location status deleted successfully')->success();
        } catch (Exception $exception) {
            flash()->message('Location status not deleted')->error();
        }

        return redirect()->route('location.index');
    }

}
