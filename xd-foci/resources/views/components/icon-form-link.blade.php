@props(['icon', 'resource'])

<a class='flex flex-col justify-center' href='{{ route($resource) }}'>
    <span class='material-icons'>{{ $icon }}</span>
</a>
