@php /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Team> $teams */ @endphp

<x-app-layout>
    <h1 class='text-5xl text-center py-4'>Csapatok</h1>
    <ol>
    @forelse($teams as $team)
    <li class='p-2 my-2 dark:bg-black/10 rounded-md hover:bg-indigo-600'>
        <a class='grid grid-cols-[5%_60%_35%] items-center text-center' href='{{ route('teams.show', $team) }}'>
            <x-team-icon :width='12' :height='12' :icon="$team->image"></x-team-icon>
            <span>{{ $team->name }}</span>
            <span>{{ $team->shortname }}</span>
        </a>
    </li>
    @empty
        <div class='text-center text-4xl py-8'>Nincsenek csapatok 😭</div>
    @endforelse
    </ol>
</x-app-layout>
