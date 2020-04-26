<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permissions\Permission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate();
        return view('admin.permissions.index', ['permissions' => $permissions]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Permission $permission
     * @return Response
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->name = $request->get('name');
        $permission->description = $request->get('description');
        $permission->update();

        flash('Permission successfully updated')->success();

        return redirect()->route('permission.index');

    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param Permission $permission
     * @return Response
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
        } catch (Exception $exception) {
            flash("Deletion of permission was not successful.")->error();
            return redirect()->back();
        }

        flash('Permission was successfully deleted.')->success();
        return redirect()->route('permission.index');
    }


    public function generate()
    {
        Artisan::call('db:seed', ['--class' => 'PermissionTableSeeder']);

        flash('Permissions successfully generated')->success();

        return redirect()->route('permission.index');
    }

}
