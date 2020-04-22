<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Console;
use App\ConsoleType;
use Illuminate\Http\Request;

class ConsoleController extends Controller
{
    public function index()
    {
        $consoles = Console::paginate(15);
        $consoleTypes = ConsoleType::get();

        return view('admin.consoles.index',['consoles' => $consoles, 'consoleTypes' => $consoleTypes]);
    }

    public function create()
    {
        return view('admin.consoles.create');
    }

    public function edit(Console $console)
    {

        return view('admin.consoles.edit',['console' => $console]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'            => 'required|string|max:255',
            'console_type_id' => 'required',
            'location_id'     => 'required',
        ]);

        Console::create($request->all());
        flash()->success('Console successfully created');

        return redirect()->route('console.index');
    }


    public function update(Console $console, Request $request)
    {
        $this->validate($request, [
            'name'            => 'required|string|max:255',
            'console_type_id' => 'required',
            'location_id'     => 'required',
        ]);

        $console->update($request->all());
        flash()->success('Console successfully updated');

        return redirect()->route('console.index');
    }

    public function delete(Console $console, Request $request)
    {
        $console->delete();
        flash()->success('Console successfully deleted');

        return redirect()->route('console.index');
    }
}
