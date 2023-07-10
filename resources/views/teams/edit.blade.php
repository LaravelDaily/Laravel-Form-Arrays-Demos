<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('teams.update', $team->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="text-xl text-gray-600" for="name">Name <span
                                        class="text-red-500">*</span></label>
                            <input type="text" class="border-2 border-gray-300 p-2 w-full" name="name" id="name"
                                   value="{{ old('name', $team->name) }}">
                            @error('name')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <livewire:team-player-selection :team="$team"/>
{{--                        --}}
{{--                        @foreach($team->users as $player)--}}
{{--                            <div class="mb-4 grid grid-cols-2">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <label class="text-xl text-gray-600" for="players[{{$player->id}}][id]">Player<span--}}
{{--                                                class="text-red-500">*</span></label>--}}
{{--                                    <select name="players[{{$player->id}}][id]" id="players[{{$player->id}}][id]"--}}
{{--                                            class="border-2 border-gray-300 p-2 w-full">--}}
{{--                                        <option value="">Select Player</option>--}}
{{--                                        @foreach($users as $id => $name)--}}
{{--                                            <option value="{{ $id }}"--}}
{{--                                                    @selected(old('players.'.$player->id.'.id', $player->id) == $id)--}}
{{--                                            >{{ $name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    @error('players.'.$player->id.'.id')--}}
{{--                                    <div class="text-red-500 mt-2 text-sm">--}}
{{--                                        {{ $message }}--}}
{{--                                    </div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <label class="text-xl text-gray-600" for="players[{{$player->id}}][position]">Position<span--}}
{{--                                                class="text-red-500">*</span></label>--}}
{{--                                    <select name="players[{{$player->id}}][position]" id="players[{{$player->id}}][position]"--}}
{{--                                            class="border-2 border-gray-300 p-2 w-full">--}}
{{--                                        <option value="">Select Position</option>--}}
{{--                                        @foreach($positions as $id => $name)--}}
{{--                                            <option value="{{ $id }}"--}}
{{--                                                    @selected(old('players.'.$player->id.'.position', $player->pivot->position) == $id)--}}
{{--                                            >{{ $name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    @error('players.'.$player->id.'.position')--}}
{{--                                    <div class="text-red-500 mt-2 text-sm">--}}
{{--                                        {{ $message }}--}}
{{--                                    </div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}

{{--                        <div class="mb-4">--}}
{{--                            @error('players')--}}
{{--                            <div class="text-red-500 mt-2 text-sm">--}}
{{--                                {{ $message }}--}}
{{--                            </div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                        <div class="mb-4">
                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Update Team
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
