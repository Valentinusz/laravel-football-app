@props(['team'])
@php
    use App\Models\Player;
    /** @var \App\Models\Team $team */
@endphp

<optgroup label='{{ $team->name }}'>
    @foreach( $team->players->sort(function (Player $a, Player $b) { return $a->number <=> $b->number; }) as $player )
        <option value='{{ $player->id }}'>{{ $player->number }} – {{ $player->name }}</option>
    @endforeach
</optgroup>
