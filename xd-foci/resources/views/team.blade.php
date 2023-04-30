@php
    use App\Models\Team;
    use App\Models\EventType;
    use Illuminate\Support\Facades\Session

    /** @var Team $team */
@endphp

<x-app-layout>
    <div class='flex flex-col items-center justify-center py-24 text-center'>
        <x-favourite-form :team=' $team '></x-favourite-form>
        <x-team-icon :icon=' $team->url() ' width='24' height='24'></x-team-icon>
        <h1 class="text-5xl">{{ $team->name }}</h1>
        <h2 class="text-3xl">{{ $team->shortname }}</h2>
    </div>
    <div class='px-16'>
        <h2 class='text-4xl'>Mérkőzések</h2>
        <section class='py-6 mb-6'>
            <table class='data-wrapper rounded-lg text-2xl w-full text-center '>
                <thead>
                <tr class='text-3xl h-16'>
                    <th>Dátum</th>
                    <th>Ellenfél</th>
                    <th>Eredmény</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $team->games->sortBy('start') as $game )
                    @php
                        $opponent = $game->homeTeam->id === $team->id ? $game->awayTeam : $game->homeTeam;
                        $score = $game->score();
                    @endphp
                    <tr class='hover:bg-indigo-600'>
                        <td class='py-2'>
                            <a href='{{ route('games.show', $game) }}' class='hover:underline'>{{ $game->start }}</a>
                        </td>
                        <td>
                            <x-team-info :team='$opponent' :render=' [0,1] ' center></x-team-info>
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

        <div class='flex gap-2'>
            <h2 class='text-4xl'>Játékosok</h2>
            <a class='icon-link' href={{ route('teams.players.create', $team) }}>
                <span class='material-icons medium hover:text-green-700'>add_circle</span>
            </a>
        </div>

        <section class='py-6'>
            <table class='data-wrapper text-2xl w-full text-center rounded-lg'>
                <thead>
                <tr class='text-3xl h-16'>
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
                            <form method='POST' action='{{ route('teams.players.destroy', [$team, $player]) }}'
                                  onsubmit='return confirm("Biztosan törölni szeretnéd a játékost?")'
                            >
                                @method('DELETE')
                                @csrf
                                <button type='submit'><span class='material-icons medium delete'>delete</span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </div>
    @if( Session::has('create') )
        <script>
            alert('Játékos sikeresen létrehozva!');
        </script>
    @endisset
    @if( Session::has('delete') )
        <script>
            alert('Játékos törlése {{ Session::get('deleteSuccess') ? '' : 'nem' }}' + ' sikerült! Csak olyan játékos törölhető akinek a nevézhez nem fűződök esemény.');
        </script>
    @endisset

</x-app-layout>
