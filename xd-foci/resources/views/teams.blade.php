@php /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Team> $teams */ @endphp

<x-app-layout>
    <h1 class="text-7xl font-bold text-center py-20">Csapatok</h1>
    <ol class='teamList'>
        <li class='w-72 h-96 data-wrapper rounded-md hover:bg-indigo-600 flex flex-col items-center justify-center'>
            <a class='h-full flex items-center' href=' {{ route('teams.create') }}'>
                <span class='material-icons large'>add_circle</span>
            </a>
        </li>
        @foreach( $teams as $team )
            <li class='w-72 h-96 p-2 data-wrapper flex-col flex rounded-md hover:bg-indigo-600'>
                <div class='flex justify-between'>
                    <button class='material-icons medium text-left'>star_border</button>
                    <a class='text-right material-icons medium text-decoration-none hover:text-yellow-600'
                       href="{{ route('teams.edit', $team) }}">edit</a>
                </div>
                <a class='h-full py-8 px-6 flex flex-col text-center gap-6'
                   href='{{ route('teams.show', $team) }}'
                >
                    <figure class='ml-auto mr-auto'>
                        <img src='{{  $team->url()  }}'>
                    </figure>
                    <span class='text-3xl'>{{ $team->name }}</span>
                    <span class='text-2xl'>{{ $team->shortname }}</span>
                </a>
            </li>
        @endforeach
    </ol>
</x-app-layout>
