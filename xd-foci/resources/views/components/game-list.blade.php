@props(['games'])
@php
    /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Game> $games */
@endphp

<ol>
    @foreach( $games as $game )
        @php
            $score = $game->score();
        @endphp
        <li class='p-2 my-2 data-wrapper rounded-md hover:bg-indigo-600 grid grid-cols-[20%_30%_10%_30%_5%_5%] items-center text-center'>
            <span>{{ $game->start->format('Y. m. d. H:i') }}</span>
            <x-team-info :team='$game->homeTeam'></x-team-info>
            <a class='text-xl' href='{{ route('games.show', $game) }}'>{{ $score['home'] }} : {{ $score['away'] }}</a>
            <x-team-info :team='$game->awayTeam' switch></x-team-info>
            <a href='{{ route('games.edit', $game) }}'>
                <span class="material-icons medium text-center hover:text-yellow-600">edit</span>
            </a>
            <form method='POST' action='{{ route('games.destroy', $game) }}'
                  onsubmit='return confirm("Biztosan törölni szeretnéd a mérkőzést?")'
            >
                @method('DELETE')
                @csrf
                <button class="material-icons medium text-center hover:text-red-700">delete</button>
            </form>
        </li>
    @endforeach
</ol>

