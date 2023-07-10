<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class TeamPlayerSelection extends Component
{
    public ?Team $team = null;
    public array $users = [];
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
    public array $players = [];

    public array $userTemplate = [
        'user_id' => "",
        'position' => ""
    ];

    protected $rules = [
        'players' => ['required', 'array', 'min:3', 'max:10'],
        'players.*.id' => ['required', 'exists:users,id', 'integer', 'distinct'],
        'players.*.position' => ['required', 'string', 'max:200', 'distinct'],
    ];

    protected $messages = [
        'players.*.id.required' => 'The player field is required.',
        'players.*.id.exists' => 'The selected player is invalid.',
        'players.*.id.distinct' => 'Player cannot be selected twice',
        'players.*.position.required' => 'Player position is required',
        'players.*.position.distinct' => 'Player positions must be unique',
    ];

    public function updated($propertyName)
    {
        $this->validate();
    }


    public function mount()
    {
        $this->users = User::pluck('name', 'id')->toArray();
        if (count(old('players', [])) > 0) {
            foreach (old('players', []) as $index => $player) {
                $this->players[$index] = [
                    'id' => $player['id'],
                    'position' => $player['position']
                ];
            }
        } elseif ($this->team) {
            $this->team->load(['users']);
            foreach ($this->team->users as $index => $player) {
                $this->players[$index] = [
                    'id' => $player->id,
                    'position' => $player->pivot->position
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.team-player-selection');
    }

    public function addUser(): void
    {
        $this->players[] = $this->userTemplate;
        $this->validate();
    }

    public function removeUser($index)
    {
        unset($this->players[$index]);
        $this->validate();
    }
}
