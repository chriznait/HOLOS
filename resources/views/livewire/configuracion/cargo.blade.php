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
                            <label class="form-label" for="basicInput">Buscar cargo</label>
                            <input type="text" class="form-control form-control-sm" id="basicInput" placeholder="Buscar..." wire:model.live.debounce.500ms="search">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Descripción</th>
                                    <th>Orden</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cargos as $item)
                                    <tr>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>{{ $item->ordenRolConsolidado }}</td>
                                        <td>
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cargos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal :modalTitulo="$tituloModal">
        <x-form-input label='Descripción' model="cargo.descripcion" wire:model='cargo.descripcion'/>
        <x-form-input label='Orden rol consolidado' model="cargo.ordenRolConsolidado" wire:model='cargo.ordenRolConsolidado' type="number"/>
    </x-modal>
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