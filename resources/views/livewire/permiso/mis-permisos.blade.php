<x-content-body :title='$tituloPagina'>
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
                                    <th>Autoriza</th>
                                    <th>Tipo</th>
                                    <th>Departamento</th>
                                    <th>Servicio</th>
                                    <th>Estado</th>
                                    <th>Salida</th>
                                    <th>Retorno</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($permisos->count() > 0)
                                    @foreach ($permisos as $item)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                            <td>{{ $item->autoriza?->nombreCompleto() }}</td>
                                            <td>{{ $item->tipo->descripcion }}</td>
                                            <td>{{ $item->empleado->departamento->descripcion }}</td>
                                            <td>{{ $item->empleado->servicio->descripcion }}</td>
                                            <td>
                                                <span class="{{ $item->estado->class }}">{{ $item->estado->descripcion }}</span>
                                            </td>
                                            <td>
                                                {{ is_null($item->fechaHoraSalida) ? '--:--' : date('H:i', strtotime($item->fechaHoraSalida)) }}
                                            </td>
                                            <td>
                                                {{ is_null($item->fechaHoraRetorno) ? '--:--' : date('H:i', strtotime($item->fechaHoraRetorno)) }}
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