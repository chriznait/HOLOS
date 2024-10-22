
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
                        <label class="form-label" for="basicInput">Buscar Sub Servicio</label>
                        <input type="text" class="form-control form-control-sm" id="basicInput" placeholder="Buscar..." wire:model.live.debounce.500ms="search">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="basicInput">UPS</label>
                        <x-select :datas="$departamentos" wire:model.live="idDepartamento"/>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="basicInput">Servicio</label>
                        @if ($idDepartamento)
                            <x-select :datas="$servicios" wire:model.live="idServicio"/>
                        @endif
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
