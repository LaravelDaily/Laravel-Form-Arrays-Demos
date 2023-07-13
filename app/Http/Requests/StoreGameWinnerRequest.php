<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameWinnerRequest extends FormRequest
{
    public function rules(): array
    {
        $gamePlayersCount = $this->route('game')->users->count();

        return [
            'players' => ['required', 'array', 'min:' . $gamePlayersCount],
            'players.*' => ['required', 'integer', 'distinct', 'min:1', 'max:' . $gamePlayersCount],
        ];
    }

    public function messages()
    {
        return [
            'players.*.required' => 'Please select a winner for each place.',
            'players.*.distinct' => 'Please select a different winner for each place.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
