{{-- <x-modal :modalTitulo="$tituloModal" :modalId="$idModal" tipo="modal-xl modal-dialog-scrollable"> --}}
<x-content-body :title='$tituloPagina'>
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>Registrado por:</th>
                                    <td>{{ $marcaciones->usuario?->empleado->nombreCompleto() }}</td>
                                    <th>Fecha registro:</th>
                                    <td>{{ date('d/m/Y H:i', strtotime($marcaciones->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Corresponde a:</th>
                                    <td>{{ date('d/m/Y', strtotime($marcaciones->fecha)) }}</td>
                                    <th>Cant. registros:</th>
                                    <td>{{ $marcaciones->cantRegistros }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Marcación</th>
                                    <th>Nombres</th>
                                    <th>Cargo</th>
                                    <th>Profesión</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($detalles) > 0)    
                                    @foreach ($detalles as $item)
                                        <tr>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ date('d/m/Y H:i', strtotime($item->marcacion)) }}</td>
                                            <td>{{ $item->empleado?->nombreCompleto() }}</td>
                                            <td>{{ $item->empleado?->cargo?->descripcion }}</td>
                                            <td>{{ $item->empleado?->profesion?->descripcion }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{ $detalles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

        {{-- <x-slot:modalFooter>
        </x-slot:modalFooter>
    </x-modal> --}}
</x-content-body>