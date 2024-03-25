<x-content-body :title='$tituloPagina'>
    <x-slot name="buttons">
        <button class="btn btn-relief-primary" wire:click='muestraModal'>Registrar</button>
    </x-slot>
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-xl-4 col-md-6 col-12">
                        <label class="form-label" for="basicInput">Buscar departamento</label>
                        <input type="text" class="form-control form-control-sm" id="basicInput" placeholder="Buscar..." wire:model.live.debounce.500ms="search">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departamentos as $item)
                                    <tr>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-icon btn-flat-success waves-effect"
                                                    title="Editar" wire:click='muestraModal({{ $item->id }})'>
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-flat-danger waves-effect"
                                                    title="Eliminar" onclick="confirmar({{ $item->id }})">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $departamentos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal :modalTitulo="$tituloModal">
        <x-form-input label='Descripción' model="departamento.descripcion" wire:model='departamento.descripcion' />
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
