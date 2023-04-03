@php
    /** @var \App\Models\Game $game */
@endphp

<x-app-layout>
    <div class='p-12'>
        <h1 class='text-5xl py-4 flex items-center gap-2'>
            <span>{{ $game->start->format('Y. m. d. H:i') }} |</span>
            <x-team-icon :width='12' :height='12' :icon='$game->homeTeam->image'></x-team-icon>
            @php $score = $game->score() @endphp
            <span>{{ $game->homeTeam->name }} ({{ $game->homeTeam->shortname }}) {{ $score['home'] }}
                :
                {{ $score['away'] }} {{ $game->awayTeam->name }} ({{ $game->awayTeam->shortname }})
            </span>
            <x-team-icon :width='12' :height='12' :icon='$game->awayTeam->image'></x-team-icon>
        </h1>

        <section class='dark:bg-black/20 px-8 py-12 rounded-lg'>
            <table class='text-2xl w-full text-center'>
                <thead>
                <tr class='text-3xl divide-x-2'>
                    <th>Perc</th>
                    <th>Csapat</th>
                    <th>Esemény</th>
                    <th>Játékos</th>
                </tr>
                </thead>
                <tbody>
                @foreach($game->events as $event)
                    <tr class='divide-x-2 hover:bg-indigo-600'>
                        <td class='py-2'>{{ $event->minute }}</td>
                        <td>
                            <span class='inline-flex'>
                            {{ $event->player->team->shortname }}
                            <x-team-icon :width='8' :height='8' :icon='$event->player->team->image'></x-team-icon>
                            </span>
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
