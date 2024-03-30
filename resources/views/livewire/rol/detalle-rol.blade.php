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
                        {{ $rol->registradoPor?->nombreCompleto() }}
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
                        {{ $rol->revisadoPor?->nombreCompleto() }}
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
    </div>
    @slot('modalFooter')
        <div x-data="counter">
            @if ($rol->estadoId == 1)
                <button class="btn btn-relief-primary" x-on:click="confirmaEstado(2)">
                    <i class="fa fa-check"></i>
                    Aprobar
                </button>
                <button class="btn btn-relief-danger" x-on:click="confirmaEstado(3)">
                    <i class="fa fa-remove"></i>
                    Rechazar
                </button>
            @endif
        </div>
    @endslot
    <script></script>
</x-modal>
@script
<script>
    Alpine.data('counter', () => {
        return {
            estados : {
                2: 'aprobar',
                3: 'rechazar',
            },
            confirmaEstado(idEstado) {
                Swal.fire({
                    text: `¿Seguro que desea ${this.estados[idEstado]}?`,
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
                        @this.setEstado(idEstado);
                    }
                });
            },
        }
    })
</script>
@endscript