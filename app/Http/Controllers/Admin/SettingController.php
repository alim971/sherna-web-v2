<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', ['settings' => $settings]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Setting $setting
     * @return Response
     */
    public function update(Request $request)
    {
        foreach (Setting::all() as $setting) {
            $setting->value = $request->get('value-' . $setting->id);
            $setting->save();
        }
        flash('Settings successfully updated')->success();

        return redirect()->route('settings.index');
    }

}
