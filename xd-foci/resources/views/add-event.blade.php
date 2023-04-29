@php
    /** @var \App\Models\Game $game */
@endphp

<x-app-layout>
    <h1 class="text-7xl font-bold text-center py-20">Új esemény</h1>
    <div class='mx-32'>
        <form class='createForm' method='POST' action='{{ route('games.events.store', $game) }}'>
            @csrf
            <!-- Minute -->
            <div>
                <label for='minute'>Perc</label>
                <input id='minute' name='minute' type='number' value='{{ old('minute') }}'>
                <x-input-error :messages="$errors->get('minute')"/>
            </div>

            <!-- EventType -->
            <div>
                <label for='type'>Esemény típus</label>
                <select id='type' name='type'>
                    @foreach( array_column(\App\Models\EventType::cases(), 'value') as $eventType )
                        <option> {{ $eventType }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')"/>
            </div>

            <!-- Player -->
            <div>
                <label for='player_id'>Játékos</label>
                <select id='player_id' name='player_id'>
                    <x-team-optgroup :team=' $game->homeTeam '></x-team-optgroup>
                    <x-team-optgroup :team=' $game->awayTeam '></x-team-optgroup>
                </select>
                <x-input-error :messages=' $errors->get("player_id") '/>
            </div>

            <button type='submit'>
                Esemény hozzáadása
            </button>
        </form>
    </div>
</x-app-layout>
