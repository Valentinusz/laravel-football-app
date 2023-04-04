@php /** @var \Illuminate\Support\Collection<array> $teams */ @endphp


<x-app-layout>
    <h1 class='text-5xl text-center py-4'>Tabella</h1>
        <section class='dark:bg-black/20 px-8 py-12 rounded-lg'>
            <table class='text-2xl w-full'>
                <thead>
                <tr class='text-3xl divide-x-2'>
                    <th>Helyezés</th>
                    <th>Csapat</th>
                    <th>Pont</th>
                    <th>Gólkülönbség</th>
                </tr>
                </thead>
                <tbody>
                @forelse($teams as $team)
                    <tr class='divide-x-2 hover:bg-indigo-600'>
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
