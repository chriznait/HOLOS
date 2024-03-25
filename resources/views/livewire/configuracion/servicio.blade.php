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
                            <label class="form-label" for="basicInput">Buscar servicio</label>
                            <input type="text" class="form-control form-control-sm" id="basicInput" placeholder="Buscar..." wire:model.live.debounce.500ms="search">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="basicInput">Departamento</label>
                            <x-select :datas="$departamentos" wire:model.live="idDepartamento"/>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Servicio</th>
                                    <th>Departamento</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($servicios as $item)
                                    <tr>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>{{ $item->departamento->descripcion }}</td>
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
                            </tbody>
                        </table>
                        {{ $servicios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal :modalTitulo="$tituloModal">
        <x-form-select :datas="$departamentos" label='Departamento' model="servicio.departamentoId" wire:model='servicio.departamentoId'/>
        <x-form-input label='Descripción' model="servicio.descripcion" wire:model='servicio.descripcion'/>
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