@props(['icon', 'label', 'resource'])

<a class='home-item' href='{{ $resource }}'>
    <span class="material-icons-outlined large">{{ $icon }}</span>
    <h3 class='text-2xl'>{{ $label }}</h3>
</a>
