<x-content-body :title='$tituloPagina'>
    <x-slot name="buttons">
        <a href='/' class="btn btn-relief-primary" type="button" tabindex="4" style="padding: 1rem 2rem; background-color:rgb(1, 148, 141)">Regresar</a>
    </x-slot>

    <div class="row" id="basic-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!--<div class="col-xl-4 col-md-6 col-12">-->
                        <div class="row">
                            
                            <div class="col-md-12" >
                        <!--<div class="col-xl-4 col-md-6 col-12">-->
                                <label class="form-label" for="basicInput"><p>Buscar Anexo</p></label>
                                <input type="text" class="form-control" id="basicInput" placeholder="Buscar..." wire:model.live.debounce.500ms="search">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ANEXO</th>
                                        <th>SERVICIO</th>
                                        <th>DETALLE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anexos as $item)
                                        <tr>
                                            <td>{{ $item->anexo }}</td>
                                            <td>
                                                {{
                                                    $item->servicio->descripcion
                                                }}
                                            </td>
                                            <td>{{ $item->descripcionLugar }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $anexos->links() }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-content-body>