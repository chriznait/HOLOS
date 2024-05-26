<x-content-body :title='$tituloPagina'>
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card" x-data="appSearch($wire)">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6" wire:ignore>
                            <select class="form-select form-select-sm select2" 
                                x-init="initializeSelect2($el)"
                            >
                                <option></option>
                            </select>
                        </div>
                        {{-- <div class="col-md-3">
                            <button type="button" class="btn btn-relief-dark" x-on:click="buscar">
                                <span wire:loading wire:target="cargarRoles" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <i class="fa fa-search"></i>
                                Buscar
                            </button>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-1" x-show="personal.codigo">
                        <table class="table table-striped table-bordered table-sm">
                            <tr>
                                <th>Nombres:</th>
                                <td colspan="3" x-text="'('+personal.nroDocumento+') '+personal.text"></td>
                            </tr>
                            <tr>
                                <th>Departamento:</th>
                                <td x-text="personal.departamento"></td>
                                <th>Servicio:</th>
                                <td x-text="personal.servicio"></td>
                            </tr>
                            <tr>
                                <th>Cargo:</th>
                                <td x-text="personal.cargo"></td>
                                <th>Profesión:</th>
                                <td x-text="personal.profesion"></td>
                            </tr>
                        </table>
                    </div>
                    <div wire:ignore id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</x-content-body>

@push('scripts')
<script>
    document.addEventListener('alpine:initializing', () => {
        Alpine.data('appSearch', (wire) => ({
            /* procedures: @entangle('procedures'), */
            personal: Object,
            init() {
                
            },
            initializeSelect2(element){
                const alpineContext = this;
                $(element).select2({
                    /* data: @this.proceduresOpc, */
                    placeholder: 'Buscar personal',
                    allowClear: false,
                    containerCssClass: 'rounded-0',
                    dropdownParent: $(element).parent(),
                    language: "es",
                    ajax: {
                        url: "{{ route('empleado.buscar') }}",
                        delay: 250,
                        dataType: 'json',
                        data: function (params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        }
                    },
                    minimumInputLength: 4,
                })/* .on("select2:selecting", function(e){

                    let data = e.params.args.data

                    if(!data.init){
                        Object.entries(alpineContext.procedures).forEach(([i, item]) => {
                            
                            if(item.IdProducto == data.id){
                                e.preventDefault()
                                showAlert({0: 
                                    {
                                        type: 'error',
                                        message: 'El procedimiento que intenta seleccionar ya esta registrado'
                                    }
                                }) 
                            }
                        });
                    }
                }) */.on("select2:select", function (e) {
                    /* const data = e.params.data
                    
                    if(!data.init){
                        let index = $(this).closest('td').attr('data-index')
                        alpineContext.procedures[index].Precio = roundDecinals(data.precio, 2)
                        alpineContext.procedures[index].IdProducto = data.id
                        alpineContext.procedures[index].Text = data.text
                        alpineContext.updateRow(index)
                    } */
                    alpineContext.personal = e.params.data;
                    alpineContext.buscar();
                })
            },
            buscar: function(){
                if(this.personal.codigo != undefined){
                    wire.getMarcaciones(this.personal.codigo).then(res => {
                        this.cargarCalendario(res);
                    })
                }else{
                    showAlert([{message: 'Seleccione un personal', type: 'error'}]);
                }
            },
            cargarCalendario: function(events){
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                editable: false,
                dayMaxEvents: true, // when too many events in a day, show the popover
                events: events
                });

                calendar.render();
            }
        }))
    })
</script>
@endpush