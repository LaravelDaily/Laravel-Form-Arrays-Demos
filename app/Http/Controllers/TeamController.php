<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('users')->get();

        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create', [
            'users' => User::pluck('name', 'id')->toArray()
        ]);
    }

    public function store(StoreTeamRequest $request)
    {
        DB::transaction(function() use ($request) {
            $team = Team::create($request->validated());

            $playersArray = [];
            foreach($request->input('players') as $player) {
                $playersArray[$player['id']] = ['position' => $player['position']];
            }
            $team->users()->attach($playersArray);
//
//            $team->users()->attach(
//                collect($request->input('players'))
//                    ->mapWithKeys(function ($item) {
//                        return [$item['id'] => ['position' => $item['position']]];
//                    })
//            );
        });

        return redirect()->route('teams.index');
    }

    public function edit(Team $team)
    {
        $team->load(['users']);

        return view('teams.edit', [
            'team' => $team,
            'users' => User::pluck('name', 'id')->toArray(),
            'teamUsers' => $team->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'position' => $user->pivot->position
                ];
            })
        ]);
    }

    public function update(StoreTeamRequest $request, Team $team)
    {
        DB::transaction(function() use ($team, $request) {
            $team->update($request->validated());

            $playersArray = [];
            foreach($request->input('players') as $player) {
                $playersArray[$player['id']] = ['position' => $player['position']];
            }
            $team->users()->sync($playersArray);
//            $team->users()->sync(
//                collect($request->input('players'))
//                    ->mapWithKeys(function ($item) {
//                        return [$item['id'] => ['position' => $item['position']]];
//                    })
//            );
        });

        return redirect()->route('teams.index');
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index');
    }
}
