@props(['teams', 'label', 'inputName'])

<label for='{{ $inputName }}'>{{ $label }}</label>
<select id='{{ $inputName }}' name='{{ $inputName }}'>
    @foreach( $teams as $team )
        <option value='{{ $team->id }}' @selected( old($inputName) == $team->id )>{{ $team->name }}</option>
    @endforeach
</select>
<x-input-error :messages=" $errors->get($inputName) "/>
