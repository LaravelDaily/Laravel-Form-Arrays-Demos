<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();

        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $users = User::pluck('name', 'id');
        $positions = [
            'Goalkeeper' => 'Goalkeeper',
            'Defender' => 'Defender',
            'Midfielder' => 'Midfielder',
            'Forward' => 'Forward',
            'Coach' => 'Coach',
            'Assistant Coach' => 'Assistant Coach',
            'Physiotherapist' => 'Physiotherapist',
            'Doctor' => 'Doctor',
            'Manager' => 'Manager',
            'President' => 'President',
        ];

        return view('teams.create', compact('users', 'positions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:teams,name', 'string', 'max:200'],
            'players' => ['required', 'array', 'min:3', 'max:10'],
            'players.*.id' => ['required', 'exists:users,id', 'integer', 'distinct'],
            'players.*.position' => ['required', 'string', 'max:200', 'distinct'],
        ], [
            'players.*.id.required' => 'The player field is required.',
            'players.*.id.exists' => 'The selected player is invalid.',
            'players.*.id.distinct' => 'Player cannot be selected twice',
            'players.*.position.distinct' => 'Player positions must be unique',
        ]);

        $team = Team::create(['name' => $request->input('name')]);

        $team->users()->sync(
            collect($request->input('players'))
                ->mapWithKeys(function ($item) {
                    return [$item['id'] => ['position' => $item['position']]];
                })
        );

        return redirect()->route('teams.index');
    }

    public function edit(Team $team)
    {
        $users = User::pluck('name', 'id');
        $team->load(['users']);
        $positions = [
            'Goalkeeper' => 'Goalkeeper',
            'Defender' => 'Defender',
            'Midfielder' => 'Midfielder',
            'Forward' => 'Forward',
            'Coach' => 'Coach',
            'Assistant Coach' => 'Assistant Coach',
            'Physiotherapist' => 'Physiotherapist',
            'Doctor' => 'Doctor',
            'Manager' => 'Manager',
            'President' => 'President',
        ];

        return view('teams.edit', compact('team', 'users', 'positions'));
    }

    public function update(Request $request, Team $team)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:teams,name,' . $team->id, 'string', 'max:200'],
            'players' => ['required', 'array', 'min:3', 'max:10'],
            'players.*.id' => ['required', 'exists:users,id', 'integer', 'distinct'],
            'players.*.position' => ['required', 'string', 'max:200', 'distinct'],
        ], [
            'players.*.id.required' => 'The player field is required.',
            'players.*.id.exists' => 'The selected player is invalid.',
            'players.*.id.distinct' => 'Player cannot be selected twice',
            'players.*.position.distinct' => 'Player positions must be unique',
        ]);

        $team->update(['name' => $request->input('name')]);

        $team->users()->sync(
            collect($request->input('players'))
                ->mapWithKeys(function ($item) {
                    return [$item['id'] => ['position' => $item['position']]];
                })
        );

        return redirect()->route('teams.index');
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index');
    }
}
