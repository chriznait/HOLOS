
    <tr>
        <td class="text-nowrap fw-bolder">{{ $nivel.' - '.$item['name'] }}</td>
        <td>
            <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" id="userManagementRead">
                <label class="form-check-label" for="userManagementRead"></label>
            </div>
        </td>
        <td>
            <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" id="userManagementRead">
                <label class="form-check-label" for="userManagementRead"></label>
            </div>
        </td>
        <td>
            <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" id="userManagementRead">
                <label class="form-check-label" for="userManagementRead"></label>
            </div>
        </td>
        <td>
            <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" id="userManagementRead">
                <label class="form-check-label" for="userManagementRead"></label>
            </div>
        </td>
        <td>
            @if ($item['submenu'])
                @foreach ($item['submenu'] as $submenu)
                    @livewire('administracion.rol-menu-item', ['item' => $submenu, 'nivel' => $nivel+1], key($submenu['id']))
                    {{-- @livewire('inicio', key(3)) --}}
                @endforeach
            @endif
        </td>
    </tr>
