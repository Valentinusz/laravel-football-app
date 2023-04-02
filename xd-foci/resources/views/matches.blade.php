<x-app-layout>
    <h1 class='text-5xl text-center'>Mérkőzések</h1>
    <h1 class='text-4xl underline decoration-indigo-400'>Folyamatban lévő mérkőzések</h1>
    <ol>
        @foreach($ongoing as $game)
            @php /** @var \App\Models\Game $game */ @endphp
            <x-game :start="date($game->start)" :score="$game->score()" :away="$game->awayTeam->name" :home="$game->homeTeam->name" ></x-game>
        @endforeach
    </ol>
    <h1 class='text-4xl underline decoration-indigo-400'>Lezárult mérkőzések</h1>
    <ol>
        @foreach($finished as $game)
            <x-game :start="date($game->start)" :score="$game->score()" :away="$game->awayTeam->name" :home="$game->homeTeam->name" ></x-game>
        @endforeach
    </ol>
</x-app-layout>
