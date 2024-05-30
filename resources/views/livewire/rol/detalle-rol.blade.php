<div>
    <x-modal :modalTitulo="$tituloModal" :modalId="$idModal" tipo="modal-xl">
        <div class="table-responsive">
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <th>Año:</th>
                        <td>
                            {{ $rol->anio }}
                        </td>
                        <th>Mes:</th>
                        <td colspan="3">
                            {{ $rol->mes() }}
                        </td>
                    </tr>
                    <tr>
                        <th>Departamento:</th>
                        <td>
                            {{ $rol->departamento?->descripcion }}
                        </td>
                        <th>Servicio:</th>
                        <td>
                            {{ $rol->servicio?->descripcion }}
                        </td>
                        <th>Estado:</th>
                        <td>
                            <span class="{{ $rol->estado?->class }}">{{ $rol->estado?->descripcion }}</span>
                        </td>
                        
                    </tr>
                    <tr>
                        <th>Registrado por:</th>
                        <td>
                            {{ $rol->registra?->nombreCompleto() }}
                        </td>
                        <th>Fecha Registro:</th>
                        <td>
                            {{ $rol->fechaCreacion() }}
                        </td>
                        <th>Observaciones:</th>
                        <td>
                            {!! nl2br($rol->observacion) !!}
                        </td>
                    </tr>
                    <tr>
                        <th>Validado por:</th>
                        <td>
                            {{ $rol->revisa?->nombreCompleto() }}
                        </td>
                        <th>Fecha validación:</th>
                        <td>
                            {{ $rol->fechaRevision() }}
                        </td>
                        <th>Validación:</th>
                        <td>
                            {{ $rol->validacion }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="btn-group">
                @if ($rol->getOriginal('estadoId') == 2)
                <a class="btn btn-flat-dark" target="_blank" href="{{ route('rol.pdf', ['idRol' => $rol->id]) }}">
                    <i class="fa-solid fa-file-pdf"></i>
                    Descargar PDF
                </a>
                @endif
                @if ($rol->getOriginal('estadoId') != 2)
                    <button class="btn btn-flat-dark" wire:click="descargarFormato"wire:loading.attr="disabled">
                        <span wire:loading wire:target="descargarFormato" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <i class="fa-solid fa-file-arrow-down"></i>
                        Descargar formato
                    </button>
                    <button class="btn btn-flat-dark" wire:click="$dispatchTo('rol.subir-rol', 'muestraSubirRol', { id: {{ $rol->id }} })">
                        <i class="fa-solid fa-file-arrow-up"></i>
                        Subir Formato
                    </button>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-rol table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="vcent">DNI</th>
                            <th rowspan="2" class="vcent">NOMBRES</th>
                            @foreach ($diasMes as $i => $dia)
                                <th class="hcent w20">{{ $i }}</th>
                            @endforeach
                            @hasanyrole('Administrador|Jefe Servicio|Jefe departamento|Recursos Humanos')
                                @foreach ($turnosExistentes as $turnoe)
                                    <th rowspan="2" class="vcent hcent w20">{{ $turnoe->turno }}</th>    
                                @endforeach
                                <th rowspan="2" class="vcent hcent">Turnos</th>
                            @endhasanyrole
                            <th rowspan="2" class="vcent hcent">Total <br> Horas</th>
                        </tr>
                        <tr>
                            @foreach ($diasMes as $i => $dia)
                                <th class="hcent">{{ $dia['inicial'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rol->empleados as $empleado)
                            <tr>
                                <td>{{ $empleado->empleado->nroDocumento }}</td>
                                <td class="text-nowrap">{{ $empleado->empleado->nombreCompleto() }}</td>
                                @php
                                    $totalHoras = 0;
                                @endphp
                                @foreach ($diasMes as $i => $dia)
                                    @php
                                        $turno = "";
                                        $dia = $i;
                                        $rolEmpleadoId = $empleado->id;
                                        foreach ($empleado->detalles as $detalle) {
                                            if($detalle->dia == $i) {
                                                $turno = $detalle->turno;
                                                $totalHoras += $detalle->rTurno?->horas;

                                                $turnosExistentes->transform(function ($item) use ($turno) {
                                                    if ($item->turno === $turno) {
                                                        $item->cantidad++;
                                                    }
                                                    return $item;
                                                });
                                            }
                                        }
                                    @endphp
                                    @if ($rol->estadoId != 2)
                                        <td wire:click="muestraModalTurno({{ $rolEmpleadoId }}, '{{ $turno }}', {{ $dia }})" class="hcent turno">
                                            {{ $turno }}
                                        </td>
                                    @else
                                        <td class="hcent turno">
                                            {{ $turno }}
                                        </td>
                                    @endif
                                @endforeach
                                @hasanyrole('Administrador|Jefe Servicio|Jefe departamento|Recursos Humanos')
                                    @foreach ($turnosExistentes as $turnoe)
                                        <th class="vcent hcent">{{ $turnoe->cantidad }}</th>    
                                    @endforeach
                                    <td class="hcent">{{ $totalHoras/6 }}</td>
                                @endhasanyrole
                                <td class="hcent">{{ $totalHoras }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @slot('modalFooter')
            
                @if ($crud['editar'])
                    @if ($rol->getOriginal('estadoId') == 3 || is_null($rol->getOriginal('estadoId')))
                        <button class="btn btn-relief-primary"
                            wire:click="publicar"
                        >
                            <i class="fa fa-check"></i>
                            Publicar
                        </button>
                    @endif
                    @can('rol revisa')
                        @if ($rol->getOriginal('estadoId') == 1)
                            <button class="btn btn-relief-primary"
                                wire:click="abrirModalEstado(2)"
                            >
                                <i class="fa fa-check"></i>
                                Aprobar
                            </button>
                        @endif
                        @if ($rol->getOriginal('estadoId') != 3 && !is_null($rol->getOriginal('estadoId')))
                            <button class="btn btn-relief-danger"
                                wire:click="abrirModalEstado(3)"
                            >
                                <i class="fa fa-remove"></i>
                                Rechazar
                            </button>
                        @endif
                    @endcan
                @endif
        @endslot
    </x-modal>
    <x-modal :modalTitulo="$tituloModalEstado" :modalId="$idModalEstado" guardar="guardarEstado">
        <x-form-text-area label="Observación" model="rol.validacion" wire:model="rol.validacion" lcol="3"/>
    </x-modal>
    <x-modal :modalTitulo="$tituloModalTurno" :modalId="$idModalTurno" guardar="guardarTurno" tipo="modal-lg">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span></br>
                @endforeach
            </div>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-sm">
                <tbody>
                    @foreach ($turnos as $i => $turno)
                        @if ($i % 2 == 0)
                        <tr>
                        @endif
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                        type="radio" 
                                        name="inlineRadioOptions" 
                                        id="inlineRadio{{ $turno->id }}" 
                                        value="{{ $turno->abrev }}"
                                        wire:model="rolDetalle.turno"
                                    >
                                </div>
                            </td>
                            <td>{{ '('.$turno->abrev.') '.$turno->descripcion }}</td>
                        @if ($i % 2 != 0 || ($i+1) == $turnos->count())
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" 
                                    type="radio" 
                                    name="inlineRadioOptions" 
                                    id="inlineRadio0" 
                                    value=""
                                    wire:model="rolDetalle.turno"
                                >
                            </div>
                        </td>
                        <td class="text-danger"><b>Sin turno</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-modal>
    @livewire('rol.subir-rol')

</div>