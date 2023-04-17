<x-app-layout>
    <header role='banner' class='h-96 py-16'>
            <h1 class="text-7xl font-bold">FociFociFoci</h1>
            <h2 class='text-5xl my-4'>Minden ami foci egy helyen.</h2>
    </header>
    <h3 class='text-center py-16 text-3xl'>Merülj el a labdarúgás világában!</h3>
        <div class='flex gap-8 justify-between mx-8'>
            <x-home-link label='Mérkőzések' icon='sports_soccer' :resource='route("games.index")'></x-home-link>
            <x-home-link label='Csapatok' icon='groupr' :resource='route("games.index")'></x-home-link>
            <x-home-link label='Tabella' icon='table_chart' :resource='route("games.index")'></x-home-link>
        </div>
</x-app-layout>
