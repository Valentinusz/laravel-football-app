@php /** @var \Illuminate\Support\Collection<array> $teams */ @endphp


<x-app-layout>
    <h1 class="text-7xl font-bold text-center py-20">Tabella</h1>
    <section class='px-24 py-12 '>
        <table class='text-2xl w-full data-wrapper rounded-lg'>
            <thead>
            <tr class='text-3xl h-24'>
                <th>Helyezés</th>
                <th>Csapat</th>
                <th title='Lejátszott mérkőzések'>LM</th>
                <th>GY</th>
                <th>D</th>
                <th>V</th>
                <th>Pont</th>
                <th>Gólkülönbség</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teams as $team)
                <tr class='hover:bg-indigo-600'>
                    <td class='py-2 text-center'>{{ $loop->iteration }}.</td>
                    <td class='px-4 flex'>
                        <button class='material-icons medium align-self-stretch'>star_border</button>
                        <a class='inline-flex items-center gap-4 py-2' href='{{ route('teams.show', $team['team']) }}'>
                            <x-team-icon :width='12' :height='12' :icon='$team["team"]->image'></x-team-icon>
                            <span>{{ $team["team"]->name }}</span>
                            <span>({{ $team["team"]->shortname }})</span>
                        </a>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class='text-center'>{{ $team['score'] }}</td>
                    <td class='text-center'>{{ $team['goalDifference'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
</x-app-layout>
