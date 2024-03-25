<x-content-body :title='$tituloPagina'>
    <x-slot name="buttons">
        <button class="btn btn-relief-primary" wire:click='muestraModal'>
            <i class="fa-solid fa-plus"></i>
            Registrar
        </button>
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
                        {{-- <div class="col-md-3">
                            <label class="form-label" for="basicInput">Departamento</label>
                            <x-select :datas="$departamentos" wire:model.live="idDepartamento"/>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nro Documento</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Nombres</th>
                                    <th>Profesión</th>
                                    <th>Departamento</th>
                                    <th>Servicio</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($empleados->count() > 0)
                                    @foreach ($empleados as $item)
                                        <tr>
                                            <td>{{ $item->nroDocumento }}</td>
                                            <td>{{ $item->apellidoPaterno }}</td>
                                            <td>{{ $item->apellidoMaterno }}</td>
                                            <td>{{ $item->nombres }}</td>
                                            <td>{{ $item->profesion?->descripcion }}</td>
                                            <td>{{ $item->departamento?->descripcion }}</td>
                                            <td>{{ $item->servicio?->descripcion }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" 
                                                        class="btn btn-icon btn-flat-success waves-effect" 
                                                        title="Editar"
                                                        wire:click='muestraModal({{ $item->id }})'
                                                    >
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <button type="button" 
                                                        class="btn btn-icon btn-flat-danger waves-effect" 
                                                        title="Eliminar"
                                                        onclick="confirmar({{ $item->id }})"
                                                    >
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
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
                        {{ $empleados->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal :modalTitulo="$tituloModal" tipo="modal-xl">
        <div class="row">
            <div class="col-sm-4">

                <x-divider text="Datos personales" />

                <x-form-select 
                    :datas="$tiposDocumento" 
                    label='Tipo documento' 
                    model="empleado.tipoDocumentoId" 
                    wire:model='empleado.tipoDocumentoId'/>
        
                <x-form-input 
                    label='Nro Documento' 
                    model="empleado.nroDocumento" 
                    wire:model='empleado.nroDocumento'/>
        
                <x-form-input 
                    label='Apellido paterno' 
                    model="empleado.apellidoPaterno" 
                    wire:model='empleado.apellidoPaterno'/>
        
                <x-form-input 
                    label='Apellido materno' 
                    model="empleado.apellidoMaterno" 
                    wire:model='empleado.apellidoMaterno'/>
        
                <x-form-input 
                    label='Nombres' 
                    model="empleado.nombres" 
                    wire:model='empleado.nombres'/>
        
                <x-form-input 
                    type="date"
                    label='Fecha de nacimiento' 
                    model="empleado.fechaNacimiento" 
                    wire:model='empleado.fechaNacimiento'/>
        
                <x-form-select 
                    :datas="$tiposSexo" 
                    label='Sexo' 
                    model="empleado.tipoSexoId" 
                    wire:model='empleado.tipoSexoId'/>
        
                
            </div>
            <div class="col-sm-4">
                <x-divider text="Datos empleado" />

                <x-form-select 
                    :datas="$profesiones" 
                    label='Profesión' 
                    model="empleado.profesionId" 
                    wire:model='empleado.profesionId'/>

                <x-form-select 
                    :datas="$cargos" 
                    label='Cargo' 
                    model="empleado.cargoId" 
                    wire:model='empleado.cargoId'/>

                <x-form-select 
                    :datas="$tiposContrato" 
                    label='Contrato' 
                    model="empleado.tipoContratoId" 
                    wire:model='empleado.tipoContratoId'/>

                <x-form-select 
                    :datas="$departamentos" 
                    wire:change="changeDepartamento($event.target.value)"
                    label='Departamento' 
                    model="empleado.departamentoId" 
                    wire:model.live='empleado.departamentoId'/>

                <x-form-select 
                    :datas="$servicios" 
                    label='Servicio' 
                    model="empleado.servicioId" 
                    wire:model.live='empleado.servicioId'/>

                <x-divider text="Credenciales" />

                <fieldset {{ !$actualizaCredenciales ? 'disabled' : '' }}>
                    <x-form-input 
                        label='Usuario' 
                        model="usuario.username" 
                        wire:model='usuario.username'/>

                    <x-form-input 
                        type="password"
                        label='Contraseña' 
                        model="usuarioPassword" 
                        wire:model='usuarioPassword'/>
                </fieldset>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" wire:model.live="actualizaCredenciales">
                    <label class="form-check-label" for="inlineCheckbox1">Actualizar credenciales</label>
                </div>
            </div>
            <div class="col-sm-4">
                <x-divider text="Roles" />
                
                @foreach ($roles as $key => $role)
                    <div class="form-check mb-1">
                        <input 
                            wire:model.live="selectedRoles" 
                            value="{{ $key }}" 
                            class="form-check-input" 
                            type="checkbox" 
                            id="role{{ $key }}">
                        <label class="form-check-label" for="role{{ $key }}" > {{ $role }} </label>
                    </div>
                @endforeach

            </div>
        </div>
        

    </x-modal>
</x-content-body>

@push('scripts')
<script>
    window.addEventListener('delayServicioId', event => {
        @this.set('empleado.servicioId', '');
        setTimeout(() => {
            @this.set('empleado.servicioId', event.detail.servicioId);
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