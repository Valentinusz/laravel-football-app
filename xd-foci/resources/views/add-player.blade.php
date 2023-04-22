@php /** @var \App\Models\Team $team */ @endphp

<x-app-layout>
    <x-short-banner title='Új játékos'></x-short-banner>
    <div class='mx-32'>
        <form class='createForm' method='POST' action='{{ route('teams.players.store', $team) }}'>
            @csrf
            <!-- Name -->
            <div>
                <label for='name'>Név</label>
                <input id='name' name='name' value='{{ old('name') }}'>
                <x-input-error :messages=" $errors->get('name') "/>
            </div>


            <!-- Number -->
            <div>
                <label for='number'>Mezszám</label>
                <input id='number' name='number' type='number' value='{{ old('number') }}'>
                <x-input-error :messages=" $errors->get('number') "/>
            </div>

            <!-- Birthdate -->
            <div>
                <label for='birthdate'>Születési dátum</label>
                <input id='birthdate' name='birthdate' type='date' value='{{ old('number') }}'>
                <x-input-error :messages=" $errors->get('birthdate') "/>
            </div>

            <button type='submit'>
                Játékos hozzáadása
            </button>
        </form>
    </div>
</x-app-layout>
