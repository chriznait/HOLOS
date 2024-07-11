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
                        {{-- <div class="col-md-3">
                            <label class="form-label" for="basicInput">Buscar usuario</label>
                            <input type="text" class="form-control form-control-sm" id="basicInput" placeholder="Buscar..." wire:model.live.debounce.500ms="search">
                        </div> --}}
                        <div class="col-md-3">
                            <select class="form-select" id="selectAnio" wire:model.live="filAnio">
                                @foreach ($anios as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="selectMes" wire:model.live="filMes">
                                @foreach ($meses as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="selectDep" wire:model.live="filDepartamento">
                                <option value="">- Departamento -</option>
                                @foreach ($departamentos as $key => $departamento)
                                <option value="{{ $key }}">{{ $departamento }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Año</th>
                                    <th>Mes</th>
                                    <th>Departamento</th>
                                    <th>Servicio</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($roles->count() > 0)
                                    @foreach ($roles as $item)
                                        <tr>
                                            <td>{{ $item->anio }}</td>
                                            <td>{{ $item->mes() }}</td>
                                            <td>{{ $item->departamento->descripcion }}</td>
                                            <td>{{ $item->servicio->descripcion }}</td>
                                            <td>
                                                @if (!is_null($item->estadoId))
                                                    <span class="{{ $item->estado->class }}">{{ $item->estado->descripcion }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" 
                                                    class="btn btn-icon btn-flat-primary waves-effect" 
                                                    title="Editar"
                                                    wire:click="$dispatchTo('rol.detalle-rol', 'muestraDetalle', { id: {{ $item->id }} })"
                                                >
                                                    <i class="fa-solid fa-list"></i>
                                                </button>
                                                @if ($empleado->id == $item->registraId && (is_null($item->revisaId) || is_null($item->estadoId)))
                                                    <div class="btn-group">
                                                        @if ($crud['editar'])
                                                            <button type="button" 
                                                                class="btn btn-icon btn-flat-success waves-effect" 
                                                                title="Editar"
                                                                wire:click='muestraModal({{ $item->id }})'
                                                            >
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        @endif
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
                                                @endif
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
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal :modalTitulo="$tituloModal">
        <x-form-select 
            :datas="$departamentos" 
            wire:change="changeDepartamento()"
            label='Departamento' 
            model="rol.departamentoId" 
            wire:model='rol.departamentoId'/>

        <x-form-select 
            :datas="$servicios" 
            label='Servicio' 
            model="rol.servicioId" 
            wire:model='rol.servicioId'/>

        <x-form-select 
            :datas="$anios" 
            label='Año' 
            model="rol.anio" 
            wire:model='rol.anio'/>

        <x-form-select 
            :datas="$meses" 
            label='Mes' 
            model="rol.mes" 
            wire:model='rol.mes'/>

        <x-form-text-area 
            label='Observaciones' 
            model="rol.observacion" 
            wire:model='rol.observacion'/>
    </x-modal>
    @livewire('rol.detalle-rol')
    
</x-content-body>

@push('scripts')
<script>
    window.addEventListener('delayServicioId', event => {
        @this.set('rol.servicioId', '');
        setTimeout(() => {
            @this.set('rol.servicioId', event.detail.servicioId);
        }, 100);
    })
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