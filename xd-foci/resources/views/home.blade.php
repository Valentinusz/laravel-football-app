<x-app-layout>
    <header role='banner'
            class='bg-[url("../../public/images/pancho.jpg")] bg-center h-96 py-16 text-center bg-fixed bg-cover
            border-b-indigo-600 border-b-4'
    >
            <h1 class="text-7xl font-bold">FociFociFoci</h1>
            <h2 class='text-5xl my-4 te'>Minden ami foci egy helyen.</h2>
    </header>
    <h2 class='text-center py-16 text-3xl'>Merülj el a labdarúgás világában!</h2>
        <div class='flex gap-8 justify-between mx-8'>
            <x-home-link label='Mérkőzések' icon='sports_soccer' :resource='route("games.index")'></x-home-link>
            <x-home-link label='Csapatok' icon='groupr' :resource='route("games.index")'></x-home-link>
            <x-home-link label='Tabella' icon='table_chart' :resource='route("games.index")'></x-home-link>
        </div>
</x-app-layout>
