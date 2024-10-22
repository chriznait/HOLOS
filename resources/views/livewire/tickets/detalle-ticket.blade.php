{{-- @php
    $txtActualiza = $
@endphp --}}
<x-modal :modalTitulo="$tituloModal">
    
        <div class="row">
            <table class="table table-sm">
                <tr>
                    <th class="fw-bolder">Fecha creacion</th>
                    <td>{{ date('d/m/Y H:i', strtotime($ticket->fechaCreacion)) }}</td>         
                </tr>
                <tr>
                    <td class="fw-bolder">Solicita:</td>
                    <td>{{ $ticket->personalAtiende?->nombreCompleto() }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Servicio</th>
                    <td>{{ $ticket->servicio?->descripcion }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Equipo</th>
                    <td>{{ $ticket->equipo }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Descripcion</th>
                    <td>{{ $ticket->detalleProblema }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Estado</th>
                    <td>{{ $ticket->estado?->descripcion }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Observaciones</th>
                    <td>{{ $ticket->observaciones }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Anexo</th>
                    <td>
                        {{ $ticket->anexo }}
                    </td>
                </tr>
            </table>
                
        </div>
  
    

    @slot('modalFooter')

    @endslot

</x-modal>