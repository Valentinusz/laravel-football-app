@php
    use App\Models\Game;
    use Illuminate\Database\Eloquent\Collection

    /** @var Collection<Game> $ongoing */
    /** @var Collection<Game> $future */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $finished */
@endphp

<x-app-layout>
    <h1 class="text-7xl font-bold text-center py-20">Mérkőzések</h1>
    <div>
        <section class='px-6 py-8'>
            <h2 class='text-4xl my-6'>Folyamatban lévő mérkőzések</h2>
            <x-game-list :games=" $ongoing "></x-game-list>
        </section>

        <section class='px-6 py-8'>
            <div class='flex gap-2'>
                <h2 class='text-4xl my-6'>Jövőbeli mérkőzések</h2>
                <a class='icon-link' href={{ route('games.create') }}>
                    <span class='material-icons medium hover:text-green-700'>add_circle</span>
                </a>
            </div>
            <x-game-list :games=" $future "></x-game-list>
        </section>

        <section class='px-6 py-8'>
            <h2 class='text-4xl py-4'>Lezárult mérkőzések</h2>
            <x-game-list :games=" $finished->items() "></x-game-list>
            <div class='text-center'>{{ $finished->links() }}</div>
        </section>
    </div>

    <script>
        @if( Session::has('create') )
        alert('Mérkőzés sikeresen létrehozva!');
        @endif

        @if( Session::has('update') )
        alert('A mérkőzés adatai frissültek!');
        @endif

        @if( Session::has('delete') )
        alert('{{ Session::get('delete') ? 'Mérkőzés sikeresen törölve!' : 'Nem sikerült törölni a mérkőzést! A mérkőzés már lezárult, vagy történt rajta esemény.' }}');
        @endif
    </script>
</x-app-layout>
