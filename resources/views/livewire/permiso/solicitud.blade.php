<x-content-body :title='$tituloPagina'>
    <x-slot name="buttons">
        {{-- <button class="btn btn-relief-primary" wire:click='muestraModal'>
            <i class="fa-solid fa-plus"></i>
            Registrar
        </button> --}}
    </x-slot>
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="basicInput">Buscar usuario</label>
                            <input type="text" class="form-control form-control-sm" id="basicInput" placeholder="Buscar..." wire:model.live.debounce.500ms="search">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nombres</th>
                                    <th>Tipo</th>
                                    <th>Departamento</th>
                                    <th>Servicio</th>
                                    <th>Estado</th>
                                    <th>Salida</th>
                                    <th>Retorno</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($permisos->count() > 0)
                                    @foreach ($permisos as $item)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                            <td>{{ $item->empleado->nombreCompleto() }}</td>
                                            <td>{{ $item->tipo->descripcion }}</td>
                                            <td>{{ $item->departamento->descripcion }}</td>
                                            <td>{{ $item->servicio->descripcion }}</td>
                                            <td>
                                                <span class="{{ $item->estado->class }}">{{ $item->estado->descripcion }}</span>
                                            </td>
                                            <td>
                                                {{ is_null($item->fechaHoraSalida) ? '--:--' : date('H:i', strtotime($item->fechaHoraSalida)) }}
                                            </td>
                                            <td>
                                                {{ is_null($item->fechaHoraRetorno) ? '--:--' : date('H:i', strtotime($item->fechaHoraRetorno)) }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" 
                                                            class="btn btn-icon btn-flat-success waves-effect" 
                                                            title="Detalles"
                                                            wire:click="$dispatchTo('permiso.form-detalle', 'muestra-modal', { id: {{ $item->id }} })"
                                                        >
                                                            <x-icon icon="list"/>
                                                        </button>
                                                    @if ($item->estadoId == 1 && $botonAprueba)
                                                        <button type="button" 
                                                            class="btn btn-icon btn-flat-primary waves-effect" 
                                                            title="Aprobar"
                                                            onclick="confirmar({{ $item->id }}, 2)"
                                                        >
                                                            <x-icon icon="check"/>
                                                        </button>
                                                        <button type="button" 
                                                            class="btn btn-icon btn-flat-danger waves-effect" 
                                                            title="Rechazar"
                                                            onclick="confirmar({{ $item->id }}, 3)"
                                                        >
                                                            <x-icon icon="xmark"/>
                                                        </button>
                                                    @endif
                                                    @if ($item->estadoId == 2 && $botonHora)
                                                        <button type="button" 
                                                            class="btn btn-icon btn-flat-info waves-effect" 
                                                            title="Hora de salida"
                                                            onclick="confirmar({{ $item->id }}, 4)"
                                                        >
                                                            <x-icon icon="clock"/>
                                                            Salida
                                                        </button>
                                                    @endif
                                                    @if ($item->estadoId == 4 && $botonHora)
                                                        <button type="button" 
                                                            class="btn btn-icon btn-flat-info waves-effect" 
                                                            title="Hora de retorno"
                                                            onclick="confirmar({{ $item->id }}, 5)"
                                                        >
                                                            <i class="fa-solid fa-clock"></i>
                                                            Retorno
                                                        </button>
                                                    @endif
                                                    
                                                    
                                                    @if (!in_array($item->estadoId, [3,5,6]) && $botonAprueba)
                                                        <button type="button" 
                                                            class="btn btn-icon btn-flat-dark waves-effect" 
                                                            title="Anular"
                                                            onclick="confirmar({{ $item->id }}, 6)"
                                                        >
                                                            <x-icon icon="ban"/>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach    
                                @else
                                    <tr>
                                        <td colspan="7">No se encontraron datos</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @if ($permisos->count() > 0)
                            {{ $permisos->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('permiso.form-detalle')
</x-content-body>

@push('scripts')
<script>
    const estados = {
        1: 'pendiente',
        2: 'aprobar',
        3: 'rechazar',
        4: 'asignar salida',
        5: 'asignar retorno',
        6: 'anular'
    };
    
    function confirmar(id, estado) {
        Swal.fire({
            text: `¿Seguro que desea ${estados[estado]}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, continuar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                @this.setEstado(id, estado);
            }
        });
    }
</script>
@endpush