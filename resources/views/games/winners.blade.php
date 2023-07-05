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
                    <form method="POST" action="{{ route('game.winners.update', $game->id) }}">
                        @csrf

                        @foreach($game->users as $user)
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div class="w-1/2">{{ $user->name }}</div>
                                <div class="w-1/2">
                                    <select name="players[{{$user->id}}]" id="players[{{$user->id}}]"
                                            class="border-2 border-gray-300 p-2 w-full">
                                        <option value="">Select Position</option>
                                        @foreach($positions as $position => $name)
                                            <option value="{{ $position }}" @selected(old('players.' . $user->id, $user->pivot->place) == $position)>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('players.'.$user->id)
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="mb-4">
                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Update Player Positions
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
