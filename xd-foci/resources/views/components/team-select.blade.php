@props(['teams', 'label', 'inputName', 'old'])

<label for='{{ $inputName }}'>{{ $label }}</label>
<select id='{{ $inputName }}' name='{{ $inputName }}'>
    @foreach( $teams as $team )
        <option value='{{ $team->id }}' @selected( $old == $team->id )>{{ $team->name }}</option>
    @endforeach
</select>
<x-input-error :messages=" $errors->get($inputName) "/>
