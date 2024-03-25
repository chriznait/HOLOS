{{-- @php
    $txtActualiza = $
@endphp --}}
<x-modal :modalTitulo="$tituloModal">
    <div class="input-group">
        <span class="input-group-text span-title fw-bolder">Nombres</span>
        <span class="form-control">
            {{ $permiso->empleado?->nombreCompleto() }}
        </span>
    </div>
    <div class="input-group">
        <span class="input-group-text fw-bolder span-title">Area</span>
        <span class="form-control">
            {{ $permiso->departamento?->descripcion . ' - '}}
            {{ $permiso->servicio?->descripcion }}
        </span>
    </div>
    <div class="input-group">
        <span class="input-group-text fw-bolder span-title">Fecha/Hora solicita</span>
        <span class="form-control">
            {{ date('d/m/Y H:i', strtotime($permiso->created_at)) }}
        </span>
    </div>
    <div class="input-group">
        <span class="input-group-text fw-bolder span-title">Tipo</span>
        <span class="form-control">
            {{ $permiso->tipo?->descripcion }}
        </span>
    </div>
    <div class="input-group">
        <span class="input-group-text fw-bolder span-title">Responsable</span>
        <span class="form-control">
            {{ $permiso->autoriza?->nombreCompleto() }}
        </span>
    </div>
    <div class="input-group">
        <span class="input-group-text fw-bolder span-title">Salida / Retorno / Estado</span>
        <span class="form-control">
            {{ is_null($permiso->fechaHoraSalida) ? '--:--' : date('H:i', strtotime($permiso->fechaHoraSalida)) }}
            {{ ' / ' }}
            {{ is_null($permiso->fechaHoraRetorno) ? '--:--' : date('H:i', strtotime($permiso->fechaHoraRetorno)) }}
            {{ ' / ' }}
            <span class="{{ $permiso->estado?->class }}">{{ $permiso->estado?->descripcion }}</span>
        </span>
    </div>
    <div class="input-group">
        <span class="input-group-text fw-bolder span-title">Fundamento</span>
        <span class="form-control">
            {{ $permiso->fundamento }}
        </span>
    </div>
    <div class="input-group">
        <span class="input-group-text fw-bolder span-title">Destino</span>
        <span class="form-control">
            {{ $permiso->destino }}
        </span>
    </div>

    @slot('modalFooter')

    @endslot

</x-modal>