@php

use App\Models\Team;
use App\Models\EventType;
use Illuminate\Support\Facades\Session

/** @var Team $team */

@endphp

<x-app-layout>
    <header role='banner'
                class='bg-[url("../../public/images/pancho.jpg")] bg-top h-64 py-16 text-center bg-fixed bg-cover
                border-b-indigo-600 border-b-4'
        >
                <div class='inline-flex justify-center flex-col'>
                    <figure class='m-auto'><x-team-icon :icon=' $team->image '></x-team-icon></figure>
                    <span class="text-5xl">{{ $team->name }}</span>
                    <span class="text-3xl">{{ $team->shortname }}</span>
                </div>
    </header>
    <div class='p-12'>
        <h2 class='text-4xl mb-6'>Mérkőzések</h2>
        <section class='data-wrapper rounded-lg py-6'>
            <table class=' text-2xl w-full text-center '>
                <thead>
                <tr class='text-3xl'>
                    <th>Dátum</th>
                    <th>Ellenfél</th>
                    <th>Eredmény</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $team->games()->sortBy('start') as $game )
                    @php
                        $opponent = $game->homeTeam->id === $team->id ? $game->awayTeam : $game->homeTeam;
                        $score = $game->score();
                    @endphp
                    <tr class='hover:bg-indigo-600'>
                        <td class='py-2'>
                            <a href='{{ route('games.show', $game) }}' class='hover:underline'>{{ $game->start }}</a>
                        </td>
                        <td>
                            <a href='{{ route('teams.show', $opponent) }}' class='hover:underline'>
                                {{ $opponent->name }}
                            </a>
                        </td>
                        <td>
                            <span class='inline-flex items-center gap-1'>
                                <x-team-icon :icon=' $game->homeTeam->image '></x-team-icon>
                                <span>
                                    {{ $game->homeTeam->shortname }}
                                    {{ $score['home'] }} : {{ $score['away'] }}
                                    {{ $game->awayTeam->shortname }}
                                </span>
                                <x-team-icon :icon=' $game->awayTeam->image '></x-team-icon>
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>

        <h2 class='text-4xl my-6 flex gap-2'>Játékosok
            <x-icon-link :link=" route('teams.players.create', $team) " icon='add_circle'></x-icon-link>
        </h2>
        <section class='mt-8 px-8 py-6'>
            <table class='data-wrapper text-2xl w-full text-center rounded-lg'>
                <thead>
                <tr class='text-3xl h-12'>
                    <th>Mezszám</th>
                    <th>Név</th>
                    <th>Születési dátum</th>
                    <th title='Gól'>⚽</th>
                    <th title='Öngól'>🥅</th>
                    <th title='Sárga lap'>🟨</th>
                    <th title='Piros lap'>🟥</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $team->players as $player )
                    <tr class='hover:bg-indigo-600'>
                        <td class='py-2'>{{ $player->number }}</td>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->birthdate }}</td>
                        <td>{{ $player->getEventCount(EventType::GOAL) }}</td>
                        <td>{{ $player->getEventCount(EventType::OWN_GOAL) }}</td>
                        <td>{{ $player->getEventCount(EventType::YELLOW_CARD) }}</td>
                        <td>{{ $player->getEventCount(EventType::RED_CARD) }}</td>
                        <td>
                            <form method='POST' action='{{ route('teams.players.destroy', [$team, $player]) }}'>
                                @method('DELETE')
                                @csrf
                                <button type='submit'><span class='material-icons'>delete</span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </div>
    @if( Session::has('deleteSuccess') )
        <script>
            alert( '{{ Session::get('deleteSuccess') ? 'Sikeres' : 'Sikertelen' }}' + ' törlés!');
        </script>
    @endisset
</x-app-layout>
