@props(['datas'])
<select {{ $attributes->merge(['class' => 'form-select form-select-sm']) }}>
    <option value="">- seleccione -</option>
    @foreach ($datas as $key => $value)
        <option 
            value="{{ $key }}" 
        >
            {{ $value }}
        </option>
    @endforeach
</select>