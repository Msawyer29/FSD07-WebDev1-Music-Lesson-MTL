@props(['name', 'options', 'required'])

<select id="{{ $name }}" name="{{ $name }}" @if($required) required @endif>
    <option value="">Select an option</option>
    @foreach ($options as $name => $id)
        <option value="{{ $id }}">{{ $name }}</option>
    @endforeach
</select>