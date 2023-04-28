@props(['team', 'switch', 'showShort', 'render', 'center'])
@php
    /** @var \App\Models\Team $team */

    $order = $render ?? [0, 1, 2 ,3];

    if (isset($switch)) {
        $order = array_reverse($order);
    }
@endphp


<div @class(['flex', 'gap-4', 'align-items-center', 'items-stretch', 'justify-end' => !isset($switch) && !isset($center), 'justify-center' => isset($center)])>
    @foreach($order as $number)
        @switch($number)
            @case(0)
                <x-favourite-form :team='$team'></x-favourite-form>
                @break
            @case(1)
                <span class='flex justify-center flex-col text-xl'>{{ $team->name }}</span>
                @break
            @case(2)
                @if( isset($showShort) )
                    <span>{{ $team->shortname }}</span>
                @endif
                @break
            @case(3)
                <x-team-icon width='12' height='12' :icon=' $team->image '></x-team-icon>
                @break
        @endswitch
    @endforeach
</div>
