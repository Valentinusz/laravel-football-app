@php /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Team> $teams */ @endphp

<x-app-layout>
    <x-short-banner title='Csapatok'></x-short-banner>
    <ol class='teamList'>
    @forelse( $teams as $team )
    <li class='w-64 h-96 data-wrapper rounded-md hover:bg-indigo-600'>
        <a class='h-full py-8 px-6 flex flex-col text-center gap-6'
           href='{{ route('teams.show', $team) }}'
        >
            <figure class='ml-auto mr-auto'><x-team-icon :icon="$team->image"></x-team-icon></figure>
            <span class='text-3xl'>{{ $team->name }}</span>
            <span class='text-2xl'>{{ $team->shortname }}</span>
        </a>
    </li>
    @empty
        <div class='text-center text-4xl py-8'>Nincsenek csapatok 😭</div>
    @endforelse
    </ol>
</x-app-layout>
