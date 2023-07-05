<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['users'])->get();

        return view('games.index', compact('games'));
    }

    public function create()
    {
        $users = User::pluck('name', 'id');

        return view('games.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:200'],
            'players' => ['required', 'array', 'min:3'],
            'players.*' => ['required', 'integer', 'exists:users,id'],
        ]);

        $game = Game::create(['name' => $request->input('name')]);
        $game->users()->sync($request->input('players'));

        return redirect()->route('game.index');
    }

    public function edit(Game $game)
    {
        $users = User::pluck('name', 'id');
        $game->load(['users']);

        return view('games.edit', compact('game', 'users'));
    }

    public function update(Request $request, Game $game)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:200'],
            'players' => ['required', 'array', 'min:3'],
            'players.*' => ['required', 'integer', 'exists:users,id'],
        ]);

        $game->update(['name' => $request->input('name')]);
        $game->users()->sync($request->input('players'));

        return redirect()->route('game.index');
    }

    public function destroy(Game $game)
    {
        $game->users()->sync([]);
        $game->delete();

        return redirect()->route('game.index');
    }
}
