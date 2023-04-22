@php /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Team> $teams */ @endphp

<x-app-layout>
    <x-short-banner title='Csapatok'></x-short-banner>
    <ol class='teamList'>
        <li class='w-64 h-96 data-wrapper rounded-md hover:bg-indigo-600 flex flex-col items-center justify-center'>
            <a class='h-full block flex items-center' href=' {{ route('teams.create') }}'>
                <span class='material-icons large'>add_circle</span>
            </a>
        </li>
        @forelse( $teams as $team )
            <li class='w-64 h-96 data-wrapper rounded-md hover:bg-indigo-600'>
                <a class='h-full py-8 px-6 flex flex-col text-center gap-6'
                   href='{{ route('teams.show', $team) }}'
                >
                    <figure class='ml-auto mr-auto'>
                        <img src='{{  $team->image  }}'>
                    </figure>
                    <span class='text-3xl'>{{ $team->name }}</span>
                    <span class='text-2xl'>{{ $team->shortname }}</span>
                </a>
            </li>
        @empty
            <div class='text-center text-4xl py-8'>Nincsenek csapatok 😭</div>
        @endforelse
    </ol>
</x-app-layout>
