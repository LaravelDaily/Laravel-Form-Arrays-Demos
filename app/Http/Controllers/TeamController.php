<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public array $positions = [
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

    public function index()
    {
        $teams = Team::with('users')->get();

        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create', [
            'users' => User::pluck('name', 'id'),
            'positions' => $this->positions,
        ]);
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
        return view('teams.edit', [
            'team' => $team,
            'users' => User::pluck('name', 'id'),
            'positions' => $this->positions,
        ]);
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
