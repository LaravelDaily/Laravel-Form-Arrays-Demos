<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(StoreTeamRequest $request)
    {
        DB::transaction(function() use ($request) {
            $team = Team::create($request->validated());
            $team->users()->attach(
                collect($request->input('players'))
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => ['position' => $item['position']]];
                    })
            );
        });

        return redirect()->route('teams.index');
    }

    public function edit(Team $team)
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

        return view('teams.edit', compact('team', 'users', 'positions'));
    }

    public function update(StoreTeamRequest $request, Team $team)
    {
        DB::transaction(function() use ($team, $request) {
            $team->update($request->validated());
            $team->users()->sync(
                collect($request->input('players'))
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => ['position' => $item['position']]];
                    })
            );
        });

        return redirect()->route('teams.index');
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index');
    }
}
