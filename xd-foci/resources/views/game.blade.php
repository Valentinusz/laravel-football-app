@php
    /** @var \App\Models\Game $game */
    $score = $game->score();

    $winner = $game->finished ? $score['home'] <=> $score['away'] : 0;
@endphp

<x-app-layout>
        <header role='banner'
                class='bg-[url("../../public/images/pancho.jpg")] bg-top h-64 py-16 text-center bg-fixed bg-cover
                border-b-indigo-600 border-b-4'
        >
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
                    <figure class='m-auto'><x-team-icon :icon='$game->awayTeam->image'></x-team-icon></figure>
                    <span class="text-3xl">{{ $game->awayTeam->name }}
                        @if( $winner === -1 ) <span class="material-icons">check_circle</span> @endif
                    </span>
                </div>

                <h2 class='text-3xl col-span-4'>{{ $game->start->format('Y. m. d. H:i') }}</h2>
            </div>
        </header>

        <section class='py-16 px-12'>
            <table class='text-1xl  w-full px-8 py-12 text-center data-wrapper rounded-lg'>
                <thead>
                <tr class='text-2xl'>
                    <th>Perc</th>
                    <th>Csapat</th>
                    <th>Esemény</th>
                    <th>Játékos</th>
                </tr>
                </thead>
                <tbody>
                @foreach($game->events as $event)
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </div>
</x-app-layout>
