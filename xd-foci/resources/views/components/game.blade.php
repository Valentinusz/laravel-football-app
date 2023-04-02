@props(['score', 'home', 'away', 'start'])

<div>
    {{ $start }} : {{ $home }} {{$score['home']}} - {{$score['away']}} {{ $away }}
</div>
