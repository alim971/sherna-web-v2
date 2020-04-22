<?php

namespace App\Http\Controllers\Admin;

use App\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function index()
    {
        $games = Game::paginate(15);

        return view('admin.games.index', ['games' => $games]);
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function edit(Game $game)
    {

        return view('admin.games.edit', ['game' => $game]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'             => 'required|string|max:255',
            'possible_players' => 'required|numeric',
            'console_id'  => 'required',
        ]);

        $game = Game::create($request->except('location_id'));
//        $game->locations()->sync($request->location_id);
        flash()->success('Game successfully created');

        return redirect()->route('game.index');

    }


    public function update(Game $game, Request $request)
    {
        $this->validate($request, [
            'name'             => 'required|string|max:255',
            'possible_players' => 'required|numeric',
            'console_type_id'  => 'required',
        ]);

        $game->update($request->except('location_id'));
        flash()->success('Game successfully updated');

        return redirect()->route('game.index');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        flash()->success('Game successfully deleted');

        return redirect()->route('game.index');

    }
}
