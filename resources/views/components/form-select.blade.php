@props(['label', 'datas', 'model', 'lcol' => "4"])
@php
    $scol  = $lcol != "" ? abs(12 - $lcol) : '';
@endphp
<div class="form-group row">
    <label class="col-sm-{{ $lcol }} col-form-label">{{ $label }}</label>
    <div class="col-sm-{{ $scol }}">
        <x-select :datas="$datas" {{ $attributes->merge(['class' => ($errors->has($model) ? ' is-invalid' : '')]) }} />
        @error($model) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>