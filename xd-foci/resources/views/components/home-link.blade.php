@props(['icon', 'label', 'resource'])

<a class='home-item' href='{{ $resource }}'>
    <span class="material-icons-outlined xl">{{ $icon }}</span>
    <h3 class='text-3xl'>{{ $label }}</h3>
</a>
