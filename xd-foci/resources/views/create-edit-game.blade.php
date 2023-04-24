@php
    $edit = isset($game);
    $title = $edit ? 'Mérkőzés szerkesztése' : 'Mérkőzés létrehozása';
@endphp

<x-app-layout>
    <h1 class="text-7xl font-bold text-center py-20">{{ $title }}</h1>
    <div class='mx-32'>
        <form class='createForm' method='POST'
              action='{{ $edit ? route('games.update', $game) : route('games.store') }}'
        >
            @if ( isset($game) )
                @method('PATCH')
            @endif
            @csrf
            <!-- Start -->
            <div>
                <label for='start'>Kezdés dátuma</label>
                <input id='start' name='start' type='datetime-local'
                       value='{{ old('start', $edit ? $game->start : '') }}'>
                <x-input-error :messages=" $errors->get('start') "/>
            </div>
            @php $teams = \App\Models\Team::all() @endphp
            <!-- Hazai csapat -->
            <div>
                <x-team-select :teams=' $teams ' inputName='home_team_id' label='Hazai csapat'
                               :old=" old('home_team_id', $edit ? $game->home_team_id : -1) "></x-team-select>
            </div>

            <!-- Vendég csapat -->
            <div>
                <x-team-select :teams=' $teams ' inputName='away_team_id' label='Vendég csapat'
                               :old=" old('away_team_id', $edit ? $game->away_team_id : -1) "></x-team-select>
            </div>

            <button type='submit'>{{ $title }}</button>
        </form>
    </div>
</x-app-layout>
