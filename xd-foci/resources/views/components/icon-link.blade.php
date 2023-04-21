@props(['icon', 'link'])

<a class='flex flex-col justify-center' href={{ $link }}>
    <span class='material-icons'>{{ $icon }}</span>
</a>
