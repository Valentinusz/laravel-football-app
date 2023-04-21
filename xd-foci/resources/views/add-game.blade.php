@php /** @var \App\Models\Team $team */ @endphp

<x-app-layout>
    <x-short-banner title='Új játékos'></x-short-banner>
    <div class='mx-32'>
        <form class='createForm' method='POST' action='{{ route('games.store') }}'>
            @csrf
            <!-- Start -->
            <div>
                <label for='start'>Kezdés dátuma</label>
                <input id='start' name='start' type='datetime-local' value='{{ old('start') }}'>
                <x-input-error :messages=" $errors->get('start') "/>
            </div>


            @php $teams = \App\Models\Team::all(); @endphp
            <!-- Hazai csapat -->
            <div>
                <x-team-select :teams=' $teams ' inputName='home_team_id' label='Hazai csapat'></x-team-select>
            </div>

            <!-- Vendég csapat -->
            <div>
                <x-team-select :teams=' $teams ' inputName='away_team_id' label='Vendég csapat'></x-team-select>
            </div>

            <button type='submit'>
                Mérkőzés létrehozása
            </button>
        </form>
    </div>
</x-app-layout>
