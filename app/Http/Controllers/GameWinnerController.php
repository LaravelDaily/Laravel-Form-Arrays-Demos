<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameWinnerController extends Controller
{
    public function edit(Game $game)
    {
        $game->load(['users']);

        $positions = [];

        for ($i = 1; $i <= $game->users->count(); $i++) {
            $positions[$i] = 'Place ' . $i;
        }

        return view('games.winners', compact('game', 'positions'));
    }

    public function update(Request $request, Game $game)
    {
        $game->load(['users']);

        $this->validate($request, [
            'players' => ['required', 'array', 'min:' . $game->users->count()],
            'players.*' => ['required', 'integer', 'distinct', 'min:1', 'max:' . $game->users->count()],
        ], [
            'players.*.required' => 'Please select a winner for each position.',
            'players.*.distinct' => 'Please select a different winner for each position.',
        ]);

        foreach ($game->users as $user) {
            $game->users()->updateExistingPivot($user->id, [
                'place' => $request->input('players.' . $user->id)
            ]);
        }

        return redirect()->route('game.index');
    }
}
