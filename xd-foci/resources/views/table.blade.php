@php /** @var \Illuminate\Support\Collection<array> $teams */ @endphp


<x-app-layout>
    <x-short-banner title='Tabella'></x-short-banner>
    <section class='px-8 py-12 '>
        <table class='text-2xl w-full data-wrapper  rounded-lg'>
            <thead>
            <tr class='text-3xl h-16'>
                <th>Helyezés</th>
                <th>Csapat</th>
                <th>Pont</th>
                <th>Gólkülönbség</th>
            </tr>
            </thead>
            <tbody>
            @forelse($teams as $team)
                <tr class='hover:bg-indigo-600'>
                    <td class='py-2 text-center'>{{ $loop->iteration }}.</td>
                    <td class='px-4'>
                        <a class='inline-flex items-center gap-4 py-2' href='{{ route('teams.show', $team['team']) }}'>
                            <x-team-icon :width='12' :height='12' :icon='$team["team"]->image'></x-team-icon>
                            <span>{{ $team["team"]->name }}</span>
                            <span>({{ $team["team"]->shortname }})</span>
                        </a>
                    </td>
                    <td class='text-center'>{{ $team['score'] }}</td>
                    <td class='text-center'>{{ $team['goalDifference'] }}</td>
                </tr>

            @empty
                <td colspan='4'><div class='text-center text-4xl py-8'>Úgy tűnik itt nincs semmi 😭</div></td>
            @endforelse
            </tbody>
        </table>
    </section>
</x-app-layout>
