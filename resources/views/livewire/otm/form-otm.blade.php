<div class="row">
    <form 
    wire:submit.prevent="guardarOtm"
    >
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title">Orden de Trabajo</h4>
                    </div>
                    <div class="col-6">
                        <label class="form-label required" for="areaUsuaria">Area Usuaria</label>
                        <input type="text" class="form-control form-control-sm" id="areaUsuaria" placeholder="Area Usuaria" 
                         disabled>
                        
                        
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="ubicacion">Ubicacion Fisica</label>
                        <input type="text" class="form-control form-control-sm" id="ubicacion" placeholder="Ubicacion Fisica" 
                        wire:model="ubicacion">
                        
                        
                    </div>
                    <div class="col-6">
                        <div class="card" x-data="appSearch($wire)">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12" wire:ignore>
                                        <label class="form-label required" for="select2">Equipo</label>
                                        <select class="form-select form-select-sm select2" 
                                            x-init="initializeSelect2($el)"
                                            wire:model="idEquipo"
                                        >
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                            
                    </div>
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Detalle Problema</label>
                        <textarea class="form-control form-control-sm" id="detalleProblema" placeholder="Detalle Problema"
                        wire:model="detalleProblema"
                        ></textarea>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Diagnostico tecnico</label>
                        <textarea class="form-control form-control-sm" id="diagnostico" placeholder="Diagnostico tecnico"
                        wire:model="diagTecnico"
                        ></textarea>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Prioridad</label>
                        <select class="form-select form-select-sm" id="prioridad" wire:model="prioridad" >
                            <option value="">Seleccione una opcion...</option>
                            <option value="MUY URGENTE">MUY URGENTE</option>
                            <option value="URGENTE">URGENTE</option>
                            <option value="PROGRAMAR">PROGRAMAR</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Modalidad Atencion</label>
                        <select class="form-select form-select-sm" id="idOtmModalidadAtencion" wire:model="idOtmModalidadAtencion">
                            <option value="">Seleccione una opcion...</option>
                            @foreach ($modalidadAtencion as $modalidad)
                                <option value="{{$modalidad->id}}">{{$modalidad->denominacion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Fe. Inicio</label>
                        <input type="dateTime-local" class="form-control form-control-sm" id="fechaInicio" placeholder="Fecha Inicio"
                        wire:model="fechaInicio"
                        >
                    </div>
                    <div class="col-6">
                        <label class="form-label">Fe. Fin</label>
                        <input type="dateTime-local" class="form-control form-control-sm" id="fechaFin" placeholder="Fecha Fin"
                        wire:model="fechaFin"
                        >
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-7">
                        <h4 class="card-title">Descripcion del trabajo realizado</h4>
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control form-control-sm" id="cantidad" placeholder="1" 
                        wire:model="cantidad"
                        >
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn-sm btn-info" x-on:click.prevent="$wire.agregarDetalleTrabajo()">
                            <i class="fa fa-plus"></i>
                            Agregar
                        </button>
                    </div>

                </div>
            </div>
            <div class="card-body">
                
                    @for( $i = 0; $i < $cantidad; $i++)
                        <div class="row">
                        <div class="col-10">
                            <input type="text" class="form-control form-control-sm" id="descripcionTrabajo" placeholder="Descripcion del trabajo"
                            wire:model= "descripcionTrabajo.{{$i}}"
                            >
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn-sm btn-danger" x-on:click="$wire.eliminarDetalleTrabajo({{$i}})">
                                <i class="fa fa-trash"></i>
                                Eliminar
                            </button>
                        </div>
                        </div>
                    @endfor
                    
                
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@push('scripts')
    <script>
        document.addEventListener('alpine:initializing', () =>  {
            Alpine.data('appSearch', (wire) => ({
                equipo: Object,
                init() {
                    
                },
                initializeSelect2(element){
                    const alpineContext = this;
                    $(element).select2({
                        placeholder: 'Seleccione un equipo',
                        allowClear: false,
                        containerCssClass: 'form-control form-control-sm',
                        dropdownParent: $(element).parent(),
                        language: "es",
                        ajax:{
                            url: "{{route('equipo.buscar')}}",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                var query = {
                                    search: params.term,
                                }
                                return query;
                            }
                        },
                        minimunInputLength: 3,
                    })
                    .on('select2:select', function (e) {
                        alpineContext.equipo = e.params.data;
                        wire.set('idEquipo', e.params.data.id);
                    })
                }
            }))
        })

    </script>  
@endpush

