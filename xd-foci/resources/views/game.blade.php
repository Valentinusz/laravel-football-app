@php
    /** @var \App\Models\Game $game */
    $score = $game->score();

    $winner = $game->finished ? $score['home'] <=> $score['away'] : 0;
@endphp

<x-app-layout>
    <div class='h-64 py-16 text-center'>
        <div class='grid grid-cols-[44%,5%,2%,5%,44%] justify-between'>
            <div class='inline-flex justify-center flex-col items-center'>
                <x-favourite-form :team=' $game->homeTeam '></x-favourite-form>
                <x-team-icon :icon='$game->homeTeam->image' height='16' width='16'></x-team-icon>
                <span class="text-3xl">{{ $game->homeTeam->name }}
                    @if( $winner === 1 )
                        <span class="material-icons text-green-700">check_circle</span>
                    @endif
                </span>
            </div>

            <div class='flex flex-col justify-center text-3xl'>{{ $score['home'] }}</div>
            <div class='flex flex-col justify-center text-3xl'>:</div>
            <div class='flex flex-col justify-center text-3xl'>{{ $score['away'] }}</div>

            <div class='inline-flex justify-center items-center flex-col'>
                <x-favourite-form :team=' $game->awayTeam '></x-favourite-form>
                <x-team-icon :icon=' $game->awayTeam->image ' height='16' width='16'></x-team-icon>
                <span class="text-3xl">{{ $game->awayTeam->name }}
                    @if( $winner === -1 )
                        <span class="material-icons text-green-700">check_circle</span>
                    @endif
                </span>

            </div>
            <h2 class='text-3xl col-span-5'>{{ $game->start->format('Y. m. d. H:i') }}</h2>
            <form method='POST' action='{{ route('games.lock', $game) }}' class='col-span-5'>
                @csrf
                <button type='submit' title='Mérkőzés lezárása'>
                    <span class='material-icons medium hover:text-indigo-600'>lock</span></button>
            </form>
        </div>
    </div>

    <section class='py-16 px-12'>
        <div class='flex gap-2'>
            <h2 class='text-4xl my-6'>Események</h2>
            <a class='icon-link' href={{ route('games.events.create', $game) }}>
                <span class='material-icons medium hover:text-green-700'>add_circle</span>
            </a>
        </div>

        <table class='text-1xl w-full text-center data-wrapper rounded-lg text-xl'>
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
                            <button type='submit'><span class='material-icons medium hover:text-red-700'>delete</span></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
</x-app-layout>
