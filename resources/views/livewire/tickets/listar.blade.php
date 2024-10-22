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
                            <label class="form-label" for="basicInput">Buscar tickets</label>
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
                                    <th>Servicio</th>
                                    <th>Equipo</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tickets->count() > 0)
                                    @foreach ($tickets as $item)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($item->fechaCreacion)) }}</td>
                                            <td>{{ $item->servicio->descripcion }}</td>
                                            <td>{{ $item->equipo }}</td>
                                            <td>{{ $item->detalleProblema }}</td>
                                            <td>{{ $item->estado->descripcion }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" 
                                                            class="btn btn-icon btn-flat-success waves-effect" 
                                                            title="Detalles"
                                                            wire:click="$dispatchTo('tickets.detalle-ticket', 'muestra-modal', { id: {{ $item->id }} })"     
                                                    >
                                                        <x-icon icon="list"/>
                                                    </button>
                                                    @if ($crud['editar'])
                                                        @if ($item->idEstadoTicket == 1)
                                                            <button type="button" 
                                                                    class="btn btn-icon btn-flat-primary waves-effect" 
                                                                    title="Asignar"
                                                                    onclick="confirmarAsignar({{ $item->id }}, 2)"
                                                            >
                                                                <x-icon icon="check"/>
                                                            </button>
                                                        @elseif ($item->idEstadoTicket == 2)
                                                            <button type="button" 
                                                                    class="btn btn-icon btn-flat-primary waves-effect" 
                                                                    title="ACT"
                                                                    onclick="confirmarTipo({{ $item->id }}, 'ACT')"
                                                            >
                                                                ACT
                                                            </button> &nbsp;
                                                            <button type="button" 
                                                                    class="btn btn-icon btn-flat-info waves-effect" 
                                                                    title="OTM"
                                                                    onclick="confirmarTipo({{ $item->id }}, 'OTM')"
                                                                    
                                                            >
                                                                OTM
                                                            </button>
                                                        @elseif ($item->idEstadoTicket == 3)
                                                            <button type="button" 
                                                                class="btn btn-icon btn-flat-danger readonly"
                                                            >
                                                                {{ $item->tipoAtencion }}
                                                            </button>
                                                            
                                                        @endif
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
                        @if ($tickets->count() > 0)
                            {{ $tickets->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('tickets.detalle-ticket')
</x-content-body>

@push('scripts')
    <script>
        function confirmarAsignar(id, estado) {
            Swal.fire({
                title: 'Asignar ticket',
                text: '¿Está seguro de asignar este ticket?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.setEstado(id, estado);
                }
            });
        }

        function confirmarTipo(id, tipo) {
            Swal.fire({
                title: 'Tipo de ticket ACT/OTM',
                text: `¿Está seguro de asignar el tipo ${tipo} a este ticket?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.setTipo(id, tipo);
                }
            });
        }

    </script>
@endpush