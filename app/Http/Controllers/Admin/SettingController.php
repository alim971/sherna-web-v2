<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ReservationService;
use App\Reservation;
use App\Setting;
use App\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', ['settings' => $settings]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
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
