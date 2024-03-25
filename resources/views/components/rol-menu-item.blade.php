@for($i = 0; $i < count($menu); $i++)
    <pre>
        {{ $menu[$i]['crear'] }}
    </pre>
    <tr>
        <td class="text-nowrap fw-bolder">{{ $menu[$i]['nivel'].' - '.$menu[$i]['name'] }}</td>
        <td>
            <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" wire:model.live="menu.{{ $i }}.ver">
            </div>
        </td>
        <td>
            <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" wire:model.live="menu.{{ $i }}.crear">
            </div>
        </td>
        <td>
            <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" wire:model.live="menu.{{ $i }}.editar" >
            </div>
        </td>
        <td>
            <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" wire:model.live="menu.{{ $i }}.eliminar" >
            </div>
        </td>
    </tr>
@endfor
