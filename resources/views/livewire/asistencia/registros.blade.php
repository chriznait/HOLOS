<x-content-body :title='$tituloPagina'>
    @if ($crud['crear'])
        <x-slot name="buttons">
            <button class="btn btn-relief-primary" wire:click='muestraModal'>
                <i class="fa-solid fa-plus"></i>
                Registrar
            </button>
        </x-slot>
    @endif
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="basicInput">Buscar usuario</label>
                            <input type="date" class="form-control form-control-sm" id="basicInput" 
                                wire:model.blur="fecha">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Cant Registros</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($marcaciones->count() > 0)
                                    @foreach ($marcaciones as $item)
                                        <tr>
                                            <td>{{ $item->fecha }}</td>
                                            <td>{{ $item->usuario->empleado->nombreCompleto() }}</td>
                                            <td>{{ $item->cantRegistros }}</td>
                                            <td>
                                                <a {{-- type="button"  --}}
                                                    class="btn btn-icon btn-flat-primary waves-effect" 
                                                    title="Editar"
                                                    {{-- wire:click="$dispatchTo('asistencia.detalle-registro', 'muestra-modal', { id: {{ $item->id }} })" --}}
                                                    {{-- href="{{ route('asistencia.registros-detalle', ['idRegistro' => $item->id]) }}" --}}
                                                    wire:click="muestraModalDetalle({{ $item->id }})"
                                                    wire:loading.attr="disabled"
                                                >
                                                    <span wire:loading wire:target="muestraModalDetalle" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    <i class="fa-solid fa-list"></i>
                                                </a>
                                                <div class="btn-group">
                                                    @if ($crud['eliminar'])
                                                        <button type="button" 
                                                            class="btn btn-icon btn-flat-danger waves-effect" 
                                                            title="Eliminar"
                                                            onclick="confirmar({{ $item->id }})"
                                                        >
                                                            <i class="fa-solid fa-trash-can"></i>
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
                        {{ $marcaciones->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal :modalTitulo="$tituloModal">

        <x-form-input type="date" label='Fecha' model="marcacion.fecha" wire:model='marcacion.fecha'/>

        <input type="file" wire:model="archivo" class="form-control">
     
        @error('archivo') <small class="text-danger">{{ $message }}</small> @enderror

    </x-modal>

    <x-modal :modalTitulo="$tituloDetalle" :modalId="$idDetalle" tipo="modal-xl modal-dialog-scrollable">
        <div class="row" id="basic-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>Registrado por:</th>
                                        <td>{{ $registro->usuario?->empleado->nombreCompleto() }}</td>
                                        <th>Fecha registro:</th>
                                        <td>{{ date('d/m/Y H:i', strtotime($registro->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Corresponde a:</th>
                                        <td>{{ date('d/m/Y', strtotime($registro->fecha)) }}</td>
                                        <th>Cant. registros:</th>
                                        <td>{{ $registro->cantRegistros }}</td>
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
                                    @if (count($registro->detalle) > 0)    
                                        @foreach ($registro->detalle as $item)
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
    {{-- @livewire('asistencia.detalle-registro') --}}
</x-content-body>

@push('scripts')
<script>
    function confirmar(id = "") {
        Swal.fire({
            text: '¿Seguro que desea eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                @this.eliminar(id);
            }
        });
    }
</script>
@endpush