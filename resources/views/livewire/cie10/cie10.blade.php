<x-content-body :title='$tituloPagina'>
    <x-slot name="buttons">
        <a href='/' class="btn btn-relief-primary" type="button" tabindex="4" style="padding: 1rem 2rem; background-color:rgb(1, 148, 141)">Regresar</a>
    </x-slot>

    <div class="row" id="basic-table">
            <div class="col-sm--12">
                <div class="card">
                    <div class="card-header">
                            <div class="form-group" >
                        
                                <label class="form-label" ><p>Buscar Descripción</p></label>
                                <input type="text" class="form-control w-full" id="basicInput" placeholder="Buscar..." wire:model.live.debounce.500ms="search" >
                            </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>CIE-10</th>
                                        <th>Descripción</th>
                                        <th>Descripcion Grupo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cie10x as $item)
                                        <tr>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->descripcion }}</td>
                                            <td>{{ $item->descrip_grupo}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $cie10x->links() }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-content-body>