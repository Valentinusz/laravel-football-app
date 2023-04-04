@php

use App\Models\Team;
use App\Models\EventType;
/** @var Team $team */

@endphp

<x-app-layout>
    <div class='p-12'>
        <h1 class='text-5xl py-4 flex items-center gap-2'>
            <x-team-icon :width='12' :height='12' :icon='$team->image'></x-team-icon>
            <span>{{ $team->name }} | {{ $team->shortname }}</span>
        </h1>

        <section class='dark:bg-black/20 px-8 py-6 rounded-lg'>
            <h2 class='text-4xl mb-6'>Mérkőzések</h2>
            <table class='text-2xl w-full text-center'>
                <thead>
                <tr class='text-3xl divide-x-2'>
                    <th>Dátum</th>
                    <th>Ellenfél</th>
                    <th>Eredmény</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($team->games()->sortBy('start') as $game)
                    <tr class='divide-x-2 hover:bg-indigo-600'>
                        <td class='py-2'><a href='{{ route('games.show', $game) }}'>{{ $game->start }}</a></td>
                        @php
                        $opponent = $game->homeTeam->id === $team->id ? $game->awayTeam : $game->homeTeam;
                        @endphp


                        <td>
                            <a href='{{ route('teams.show', $opponent) }}' class="underline">
                                {{ $opponent->name }}
                            </a>
                        </td>

                        @php $score = $game->score(); @endphp
                        <td>
                            <span class='inline-flex items-center gap-1'>
                                <x-team-icon :width='12' :height='12' :icon='$game->homeTeam->image'></x-team-icon>
                                <span>
                                    {{ $game->homeTeam->shortname }}
                                    {{ $score['home'] }} : {{ $score['away'] }}
                                    {{ $game->awayTeam->shortname }}
                                </span>
                                <x-team-icon :width='12' :height='12' :icon='$game->awayTeam->image'></x-team-icon>
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>

        <section class='dark:bg-black/20 mt-8 px-8 py-6 rounded-lg'>
            <h2 class='text-4xl mb-6'>Játékosok</h2>
            <table class='text-2xl w-full text-center '>
                <thead>
                <tr class='text-3xl divide-x-2'>
                    <th>Mezszám</th>
                    <th>Név</th>
                    <th>Születési dátum</th>
                    <th>⚽Gól</th>
                    <th>🥅Öngól</th>
                    <th>🟨Sárga lap</th>
                    <th>🟥Piros lap</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($team->players as $player)
                    <tr class='hover:bg-indigo-600 divide-x-2'>
                        <td class='py-2'>{{ $player->number }}</td>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->birthdate }}</td>
                        <td>{{ $player->getEventCount(EventType::GOAL) }}</td>
                        <td>{{ $player->getEventCount(EventType::OWN_GOAL) }}</td>
                        <td>{{ $player->getEventCount(EventType::YELLOW_CARD) }}</td>
                        <td>{{ $player->getEventCount(EventType::OWN_GOAL) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </div>
</x-app-layout>
