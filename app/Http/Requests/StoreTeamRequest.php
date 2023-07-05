<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'players' => ['required', 'array', 'min:3', 'max:10'],
            'players.*.id' => ['required', 'exists:users,id', 'integer', 'distinct'],
            'players.*.position' => ['required', 'string', 'max:200', 'distinct'],
        ];
    }

    public function messages()
    {
        return [
            'players.*.id.required' => 'The player field is required.',
            'players.*.id.exists' => 'The selected player is invalid.',
            'players.*.id.distinct' => 'Player cannot be selected twice',
            'players.*.position.distinct' => 'Player positions must be unique',
        ];
    }
}
