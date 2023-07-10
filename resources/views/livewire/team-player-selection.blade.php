<div>

    @foreach($players as $i => $user)
        <div class="mb-4 grid grid-cols-3 gap-4">
            <div class="">
                <label class="text-xl text-gray-600" for="players[{{$i}}][id]">Player<span
                            class="text-red-500">*</span></label>
                <select name="players[{{$i}}][id]" id="players[{{$i}}][id]"
                        wire:model="players.{{$i}}.id"
                        class="border-2 border-gray-300 p-2 w-full">
                    <option value="">Select Player</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}"
                                @if(in_array($id, collect($players)->filter(fn($value, $key) => $key != $i)->pluck('id')->toArray()))
                                    disabled
                                @endif
                                @selected(old('players.'.$i.'.id') == $id)
                        >{{ $name }}</option>
                    @endforeach
                </select>
                @error('players.'.$i.'.id')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="">
                <label class="text-xl text-gray-600" for="players[{{$i}}][position]">Position<span
                            class="text-red-500">*</span></label>
                <select name="players[{{$i}}][position]" id="players[{{$i}}][position]"
                        wire:model="players.{{$i}}.position"
                        class="border-2 border-gray-300 p-2 w-full">
                    <option value="">Select Position</option>
                    @foreach($positions as $id => $name)
                        <option value="{{ $id }}"
                                @if(in_array($id, collect($players)->filter(fn($value, $key) => $key != $i)->pluck('position')->toArray()))
                                    disabled
                                @endif
                                @selected(old('players.'.$i.'.position') == $id)
                        >{{ $name }}</option>
                    @endforeach
                </select>
                @error('players.'.$i.'.position')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="">
                <button wire:click.prevent="removeUser({{$i}})"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-8">
                    Remove
                </button>
            </div>
        </div>
    @endforeach

    <div class="mb-4">
        @error('players')
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
    </div>

    <button wire:click.prevent="addUser"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
        Add Player
    </button>
</div>