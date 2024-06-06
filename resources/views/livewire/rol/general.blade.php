<x-content-body :title='$tituloPagina'>
    <x-slot name="buttons">
        {{-- <button class="btn btn-relief-primary" wire:click='descargarXls' wire:loading.attr="disabled">
            <span wire:loading wire:target="descargarXls" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fa fa-download"></i>
            Registrar
        </button> --}}
        <div class="btn-group">
            <button class="btn btn-relief-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-download"></i>
                Descargar Rol
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <button class="dropdown-item" id="btn-xlsx">
                    <i class="fa fa-file-excel"></i>
                    Formato excel
                </button>
                @hasanyrole('Administrador|Recursos Humanos')
                <button class="dropdown-item" id="btn-resumen">
                    <i class="fa fa-file-pdf"></i>
                    Resumen PDF
                </button>
                @endhasanyrole
            </div>
        </div>
    </x-slot>
    

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form wire:submit="cargarRoles">
                        <div class="row">
                            <div class="col-md-2">
                                <select class="form-select" id="selectAnio" wire:model="filAnio">
                                    @foreach ($anios as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="selectMes" wire:model="filMes">
                                    @foreach ($meses as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="selectDep" wire:model="filDepartamento">
                                    <option value="">- Departamento -</option>
                                    @foreach ($departamentos as $key => $departamento)
                                    <option value="{{ $key }}">{{ $departamento }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" wire:model="filText" placeholder="Buscar...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-relief-dark" wire:loading.attr="disabled">
                                    <span wire:loading wire:target="cargarRoles" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <i class="fa fa-search"></i>
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-rol table-bordered">
                            <tbody>
                                @foreach ($departamentosRol as $departamento)
                                    <tr>
                                        <th class="text-center departamento text-danger" colspan="{{ count($turnos) + count($diasMes)+2 }}">
                                            {{ strtoupper($departamento->descripcion) }}
                                        </th>
                                    </tr>
                                    @foreach ($departamento->servicios as $servicio)
                                        @if ($servicio->roles->count() > 0)
                                            <tr>
                                                <th class="servicio text-primary" colspan="{{ count($turnos) + count($diasMes)+2 }}">
                                                    {{ $servicio->descripcion }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" class="vcent">NOMBRES</th>
                                                @foreach ($diasMes as $i => $dia)
                                                    <th class="hcent cab-rol">{{ $i }}</th>
                                                @endforeach
                                                @hasanyrole('Administrador|Jefe Servicio|Jefe departamento|Recursos Humanos')
                                                    @foreach ($turnos as $turno)
                                                        <th rowspan="2" class="vcent hcent cab-rol">{{ $turno->turno }}</th>    
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
                                            @foreach ($servicio->roles[0]->empleados as $empleado)
                                            @php
                                                $turnos->transform(function ($item) {
                                                    $item->cantidad = 0;
                                                    return $item;
                                                });
                                            @endphp
                                                <tr>
                                                    <td style="white-space: nowrap;">
                                                        {{ strtoupper($empleado->empleado->nombreCompleto()) }}<br>
                                                        {{ $empleado->empleado->cargo?->descripcion }}
                                                    </td>
                                                    @php
                                                        $totalHoras = 0;
                                                        $turnos->transform(function ($item) use ($turno) {
                                                            $item->cantidad = 0;
                                                            return $item;
                                                        });
                                                    @endphp
                                                    @foreach ($diasMes as $i => $dia)
                                                        @php
                                                            $turno = "";
                                                            foreach ($empleado->detalles as $detalle) {
                                                                if($detalle->dia == $i) {
                                                                    $turno = $detalle->turno;
                                                                    $totalHoras += $detalle->rTurno->horas;

                                                                    $turnos->transform(function ($item) use ($turno) {
                                                                        if ($item->turno === $turno) {
                                                                            $item->cantidad++;
                                                                        }
                                                                        return $item;
                                                                    });

                                                                }
                                                            }
                                                        @endphp
                                                        <td class="hcent">{{ $turno }}</td>
                                                    @endforeach
                                                    @hasanyrole('Administrador|Jefe Servicio|Jefe departamento|Recursos Humanos')
                                                        @foreach ($turnos as $turno)
                                                            <th class="vcent hcent">{{ $turno->cantidad }}</th>    
                                                        @endforeach
                                                        <td class="hcent">{{ $totalHoras/6 }}</td>
                                                    @endhasanyrole
                                                    <td class="hcent">{{ $totalHoras }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-content-body>
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#btn-xlsx').click(function(){
                let anio = $('#selectAnio').val();
                let mes = $('#selectMes').val();
                let departamento = $('#selectDep').val();
                let ruta = @json(route('rol.general-xlsx')) + '?anio=' + anio + '&mes=' + mes + '&departamento=' + departamento;
                window.open(ruta, '_blank');
            })

            $('#btn-resumen').click(function(){
                let anio = $('#selectAnio').val();
                let mes = $('#selectMes').val();
                let ruta = @json(route('rol.resumen')) + '?anio=' + anio + '&mes=' + mes;
                window.open(ruta, '_blank');
            })
        })
    </script>
@endpush