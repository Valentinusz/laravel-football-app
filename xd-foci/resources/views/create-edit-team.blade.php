@php
    $edit = isset($team);
    $title = $edit ? 'Csapat szerkesztése' : 'Csapat létrehozása';
@endphp

<x-app-layout>
    <h1 class="text-7xl font-bold text-center py-20">{{ $title }}</h1>
    <div class='mx-32'>
        <form class='createForm' method='POST'
              action='{{ $edit ? route('teams.update', $team) : route('teams.store') }}'
              enctype='multipart/form-data'
        >
            @if ( isset($team) )
                @method('PATCH')
            @endif
            @csrf
            <!-- Name -->
            <div>
                <label class='required' for='name'>Csapat neve</label>
                <input id='name' name='name' value='{{ old('name', $edit ? $team->name : '') }}'>
                <x-input-error :messages=" $errors->get('name') "/>
            </div>

            <!-- Shortname -->
            <div>
                <label class='required' for='shortname'>Csapat rövidítése</label>
                <input id='shortname' name='shortname' value='{{ old('shortname', $edit ? $team->shortname : '') }}'>
                <x-input-error :messages=" $errors->get('shortname') "/>
            </div>

            <!-- Image -->
            <div>
                <label for='image'>Csapat logója</label>
                <input id='image' name='image' type='file'>
                <x-input-error :messages=" $errors->get('image') "/>
            </div>

            <button type='submit'>{{ $title }}</button>
        </form>
    </div>
</x-app-layout>
