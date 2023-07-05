<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameWinnerController extends Controller
{
    public function edit(Game $game)
    {
        $game->load(['users']);

        $places = [];

        for ($i = 1; $i <= $game->users->count(); $i++) {
            $places[$i] = 'Place ' . $i;
        }

        return view('games.winners', compact('game', 'places'));
    }

    public function update(Request $request, Game $game)
    {
        $game->load(['users']);

        $this->validate($request, [
            'players' => ['required', 'array', 'min:' . $game->users->count()],
            'players.*' => ['required', 'integer', 'distinct', 'min:1', 'max:' . $game->users->count()],
        ], [
            'players.*.required' => 'Please select a winner for each place.',
            'players.*.distinct' => 'Please select a different winner for each place.',
        ]);

        foreach ($game->users as $user) {
            $game->users()->updateExistingPivot($user->id, [
                'place' => $request->input('players.' . $user->id)
            ]);
        }

        return redirect()->route('game.index');
    }
}
