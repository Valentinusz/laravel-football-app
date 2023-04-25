@props(['team'])
@php
    /** @var \App\Models\User $user */
    $user = \Illuminate\Support\Facades\Auth::user();
    $favourite = $user && $user->teams->contains($team)
@endphp
<form method='POST' action='{{ route('teams.favourite', $team) }}'
      class='flex items-center'
>
    @csrf
    <button type='submit' class='material-icons medium text-center'
            title='{{ $favourite ? 'Törlés a kedvencekből' : 'Hozzáadás a kedvencekhez' }}'
    >
        {{ $favourite  ? 'star' : 'star_border'}}
    </button>
</form>
