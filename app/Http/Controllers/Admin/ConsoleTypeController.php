<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consoles\ConsoleType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConsoleTypeController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.consoles.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
     * Show the form for editing the specified resource.
     *
     * @param ConsoleType $consoleType
     * @return Response
     */
    public function edit(ConsoleType $type)
    {
        return view('admin.consoles.types.edit', ['consoleType' => $type]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ConsoleType $consoleType
     * @return Response
     */
    public function update(Request $request, ConsoleType $type)
    {

        $type->update($request->all());
        flash()->success('Console type successfully updated');

        return redirect()->route('console.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConsoleType $consoleType
     * @return Response
     */
    public function destroy(ConsoleType $type)
    {
        $type->delete();
        return redirect()->route('console.index');
    }
}
