@php
    /** @var \App\Models\Game $game */
    $score = $game->score();

    $winner = $game->finished ? $score['home'] <=> $score['away'] : 0;
@endphp

<x-app-layout>
    <header role='banner' class='h-64 py-16'>
        <div class='grid grid-cols-[40%,10%,10%,40%] justify-between'>
            <div class='inline-flex justify-center flex-col'>
                <figure class='m-auto'><x-team-icon :icon='$game->homeTeam->image'></x-team-icon></figure>
                <span class="text-3xl">{{ $game->homeTeam->name }}
                    @if( $winner === 1 ) <span class="material-icons">check_circle</span> @endif
                </span>
            </div>

            <div class='flex flex-col justify-center text-3xl'>{{ $score['home'] }}</div>
            <div class='flex flex-col justify-center text-3xl'>{{ $score['away'] }}</div>

            <div class='inline-flex justify-center flex-col'>
                <figure class='m-auto'><x-team-icon :icon=' $game->awayTeam->image '></x-team-icon></figure>
                <span class="text-3xl">{{ $game->awayTeam->name }}
                    @if( $winner === -1 ) <span class="material-icons">check_circle</span> @endif
                </span>
            </div>

            <h2 class='text-3xl col-span-4'>{{ $game->start->format('Y. m. d. H:i') }}</h2>
        </div>
    </header>

    <section class='py-16 px-12'>
        <div class='flex item-center'>
            <h2 class='text-2xl'>Események</h2>
            <a href='{{ route('games.events.create', $game) }}'><span class='material-icons medium'>add_circle</span></a>
            <form method='POST' action='{{ route('games.lock', $game) }}'>
                @csrf
                <button type='submit'><span class='material-icons medium'>lock</span></button>
            </form>
        </div>

        <table class='text-1xl w-full text-center data-wrapper rounded-lg'>
            @foreach( $game->events as $event )
                <tr class='hover:bg-indigo-600'>
                    <td class='py-2'>{{ $event->minute }}'</td>
                    <td>
                        {{ $event->player->team->name }}
                    </td>
                    <td @class([
                            "before:content-['⚽']" => $event->type === 'gól',
                            "before:content-['🥅']" => $event->type === 'öngól',
                            "before:content-['🟨']" => $event->type === 'sárga lap',
                            "before:content-['🟥']" => $event->type === 'piros lap'
                        ])>{{ $event->type }}</td>
                    <td>{{ $event->player->name }}</td>
                    <td>
                        <form method='POST' action='{{ route('games.events.destroy', [$game, $event]) }}'>
                            @method('DELETE')
                            @csrf
                            <button type='submit'><span class='material-icons'>delete</span></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
</x-app-layout>
