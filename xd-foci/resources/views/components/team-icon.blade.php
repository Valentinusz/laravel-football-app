@props(['width', 'height', 'icon'])

<img class='w-{{$width}} h-{{$height}}' src='{{ $icon ?? asset("images/dummy.png")}}' alt='csapat logo'>
