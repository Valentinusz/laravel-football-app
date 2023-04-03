@php
/** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Game> $ongoing */
/** @var \Illuminate\Pagination\LengthAwarePaginator $finished */
@endphp

<x-app-layout>
    <h1 class='text-5xl text-center py-6'>Mérkőzések</h1>
    <div class='grid grid-cols-2'>
        <section class='px-6 py-8 w-full'>
            <h2 class='text-4xl underline decoration-indigo-600 py-4'>Folyamatban lévő mérkőzések</h2>
            <x-game-list :games="$ongoing"></x-game-list>
        </section>

        <section class='px-6 py-8'>
            <h2 class='text-4xl underline decoration-indigo-600 py-4'>Lezárult mérkőzések</h2>
            <x-game-list :games="$finished->items()"></x-game-list>
            <div class='text-center'>
                {{ $finished->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
