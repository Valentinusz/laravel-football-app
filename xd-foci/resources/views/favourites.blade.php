@php
    /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Game> $games */
error_log($games->count())
@endphp

<x-app-layout>
    <h1 class="text-7xl font-bold text-center py-20">Kedvencek</h1>
    <x-game-list :games=" $games "></x-game-list>
</x-app-layout>
