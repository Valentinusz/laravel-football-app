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
                <input id='minute' name='minute' type='@production number @endproduction @env('local') text @endenv'
                       value='{{ old('minute') }}'
                >
                <x-input-error :messages="$errors->get('minute')"/>
            </div>

            <!-- EventType -->
            <div>
                <label for='type'>Esemény típus</label>
                <select id='type' name='type'>
                    @env('local') <option>NOT ENUM VALUE VALIDATION DEBUG OPTION</option> @endenv
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
                    @env('local') <option value='X'>DEBUG OPTION FOR VALIDATION (INVALID PLAYER ID)</option> @endenv

                    {{-- USES PLAYER WITH ID 1 AS INVALID SO THIS PASSES IF PLAYER 1 IS IN ONE OF THE TEAMS --}}
                    @env('local') <option value='1'>DEBUG OPTION FOR VALIDATION (PLAYER NOT ON TEAM)</option> @endenv
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
