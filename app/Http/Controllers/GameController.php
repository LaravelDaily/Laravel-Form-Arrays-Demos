<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('users')->get();

        return view('games.index', compact('games'));
    }

    public function create()
    {
        $users = User::pluck('name', 'id');

        return view('games.create', compact('users'));
    }

    public function store(StoreGameRequest $request)
    {
        DB::transaction(function() use ($request) {
            $game = Game::create($request->validated());
            $game->users()->attach($request->input('players'));
        });

        return redirect()->route('games.index');
    }

    public function edit(Game $game)
    {
        $users = User::pluck('name', 'id');

        return view('games.edit', compact('game', 'users'));
    }

    public function update(StoreGameRequest $request, Game $game)
    {
        DB::transaction(function() use ($game, $request) {
            $game->update($request->validated());
            $game->users()->sync($request->input('players'));
        });

        return redirect()->route('games.index');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('games.index');
    }
}
