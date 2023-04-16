@props(['width', 'height', 'icon'])

<img class='w-{{ $width ?? 12}} h-{{ $height ?? 12 }}' src='{{ $icon ?? asset("images/dummy.png")}}' alt='csapat logo'>
