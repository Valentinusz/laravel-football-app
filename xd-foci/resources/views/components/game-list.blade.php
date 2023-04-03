@props(['games'])
@php /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Game> $games */ @endphp

<style>
    a {
        grid-template-columns: auto 3rem auto auto auto 3rem;
    }
</style>

<ol>
    @forelse($games as $game)
    @php
        $score = $game->score();
    @endphp
    <li class='p-2 my-2 dark:bg-black/10 rounded-md hover:bg-indigo-600'>
        <a class='grid grid-cols-[20%_5%_30%_10%_30%_5%] items-center text-center' href='{{ url("game/$game->id") }}'>
            <span>{{ $game->start->format('Y. m. d. H:i') }}</span>
            <img class='w-12 h-12' src='{{ $game->homeTeam->image ?? asset("images/dummy.png") }}' alt='ikon'>
            <span>{{ $game->homeTeam->name }}</span>
            <span>{{ $score['home'] }} : {{ $score['away'] }}</span>
            <span>{{ $game->awayTeam->name }}</span>
            <img class='w-12 h-12' src='{{ $game->awayTeam->image ?? asset("images/dummy.png")}}' alt='ikon'>
        </a>
    </li>
    @empty
        <div class='text-center text-4xl py-8'>Nincs meccs 😭</div>
    @endforelse
</ol>

