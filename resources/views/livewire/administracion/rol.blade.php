<x-content-body :title='$tituloPagina'>
    <x-slot name="buttons">
        @if ($crud['crear'])
            <button class="btn btn-relief-primary" wire:click='muestraModal'>
                <i class="fa-solid fa-plus"></i>
                Registrar
            </button>
        @endif
    </x-slot>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label" for="basicInput">Buscar rol</label>
                            <input type="text" class="form-control form-control-sm" id="basicInput"
                                placeholder="Buscar..." wire:model.live.debounce.500ms="search">
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
                                    <th>Rol</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($roles->count() > 0)
                                    @foreach ($roles as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    @if ($crud['editar'])
                                                    <button type="button"
                                                        class="btn btn-icon btn-flat-success waves-effect"
                                                        title="Editar" wire:click='muestraModal({{ $item->id }})'>
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    @endif
                                                    @if ($crud['eliminar'])
                                                    <button type="button"
                                                        class="btn btn-icon btn-flat-danger waves-effect"
                                                        title="Eliminar" onclick="confirmar({{ $item->id }})">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                    @endif
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
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-modal :modalTitulo="$tituloModal" tipo="modal-xl">
        <div class="col-12">
            <label class="form-label" for="modalRoleName">Nombre Rol</label>
            <input wire:model="rol.name" type="text" id="modalRoleName" class="form-control"
                placeholder="Enter role name" tabindex="-1" data-msg="Please enter role name">
        </div>
        <div class="row">
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table table-flush-spacing">
                        <tbody>
                            <tr>
                                <td class="text-nowrap fw-bolder p-tb-0">
                                    <h4 class="mb-0">Permisos en Menú</h4>
                                </td>
                                <td class="text-nowrap fw-bolder col-sm-1">
                                    Ver
                                </td>
                                <td class="text-nowrap col-sm-1">
                                    Crear
                                </td>
                                <td class="text-nowrap col-sm-1">
                                    Editar
                                </td>
                                <td class="text-nowrap col-sm-1">
                                    Eliminar
                                </td>
                            </tr>
                            @for($i = 0; $i < count($menu); $i++)
                                <tr>
                                    <td class="text-nowrap p-tb-0">
                                        {{ str_repeat('--', $menu[$i]['nivel']) }}
                                        {{ $menu[$i]['name'] }}
                                    </td>
                                    <td class="p-tb-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="menu.{{ $i }}.ver" wire:change="changeVer({{ $i }})">
                                        </div>
                                    </td>
                                    <td class="p-tb-0">
                                        <div class="form-check">
                                            @if (!$menu[$i]['submenu'])
                                                <input class="form-check-input" type="checkbox" wire:model="menu.{{ $i }}.crear">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-tb-0">
                                        <div class="form-check">
                                            @if (!$menu[$i]['submenu'])
                                                <input class="form-check-input" type="checkbox" wire:model="menu.{{ $i }}.editar">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-tb-0">
                                        <div class="form-check">
                                            @if (!$menu[$i]['submenu'])
                                                <input class="form-check-input" type="checkbox" wire:model="menu.{{ $i }}.eliminar">
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endfor

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6 mt-1" style="border-left: solid #6e6b7b 2px">
                @foreach ($permisos as $permiso)
                    <div class="form-check">
                        <input class="form-check-input" 
                            type="checkbox" 
                            id="checkbox{{ $permiso->id }}" 
                            value="{{ $permiso->id }}"
                            wire:model="permisosSeleccionados">
                        <label class="form-check-label" for="checkbox{{ $permiso->id }}">{{ $permiso->name }}</label>
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
