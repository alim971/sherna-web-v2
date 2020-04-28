<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consoles\ConsoleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ConsoleTypeController extends Controller
{

    /**
     * Show the form for creating a new Console Type.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.consoles.types.create');
    }

    /**
     * Store a newly created Console Type in database.
     *
     * @param Request $request  request containing data from creation form
     * @return RedirectResponse return index view of console and console types
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        ConsoleType::create($request->all());
        flash()->success('Console type successfully created');

        return redirect()->route('console.index');
    }


    /**
     * Show the form for editing the specified Console Type.
     *
     * @param ConsoleType $type  console type to be edited
     * @return View              return view with edition form
     */
    public function edit(ConsoleType $type)
    {
        return view('admin.consoles.types.edit', ['consoleType' => $type]);

    }

    /**
     * Update the specified Console Type in database.
     *
     * @param Request $request  request containing all the data from edition form
     * @param ConsoleType $type Console type to be updated
     * @return RedirectResponse return index view with consoles and console types
     */
    public function update(Request $request, ConsoleType $type)
    {

        $type->update($request->all());
        flash()->success('Console type successfully updated');

        return redirect()->route('console.index');
    }

    /**
     * Remove the specified Console Type from storage.
     *
     * @param ConsoleType $type console type to be removed
     * @return RedirectResponse return index view with consoles and console types
     */
    public function destroy(ConsoleType $type)
    {
        $type->delete();
        return redirect()->route('console.index');
    }
}
