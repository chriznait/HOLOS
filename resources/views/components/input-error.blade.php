@props(['for'])

@error($for)
    <small {{ $attributes->merge(['class' => 'text-danger']) }}>{{ $message }}</small>
@enderror
