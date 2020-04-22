<?php

namespace App\Http\Controllers\Admin;

use App\ConsoleType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsoleTypeController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.consoles.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * @param  \App\ConsoleType  $consoleType
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsoleType $type)
    {
        return view('admin.consoles.types.edit', ['consoleType' => $type]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConsoleType  $consoleType
     * @return \Illuminate\Http\Response
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
     * @param  \App\ConsoleType  $consoleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsoleType $type)
    {
        $type->delete();
        return redirect()->route('console.index');
    }
}
