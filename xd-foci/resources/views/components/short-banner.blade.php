@props(['height', 'title'])

<header role='banner'
        class='bg-[url("../../public/images/pancho.jpg")] bg-center h-64 py-16 text-center bg-fixed bg-cover
        border-b-indigo-600 border-b-4'
>
        <h1 class="text-7xl font-bold">{{ $title }}</h1>
        {{ $slot }}
</header>
