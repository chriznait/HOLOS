<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-basic px-2">
                <div class="auth-inner my-2">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="/" class="brand-logo">
                                <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                                    <defs>
                                        <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%"
                                            x2="50%" y2="89.4879456%">
                                            <stop stop-color="#000000" offset="0%"></stop>
                                            <stop stop-color="#FFFFFF" offset="100%"></stop>
                                        </lineargradient>
                                        <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%"
                                            x2="37.373316%" y2="100%">
                                            <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                            <stop stop-color="#FFFFFF" offset="100%"></stop>
                                        </lineargradient>
                                    </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd">
                                        <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                            <g id="Group" transform="translate(400.000000, 178.000000)">
                                                <path class="text-primary" id="Path"
                                                    d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                                    style="fill: currentColor"></path>
                                                <path id="Path1"
                                                    d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                                    fill="url(#linearGradient-1)" opacity="0.2"></path>
                                                <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                                    points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                                </polygon>
                                                <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                                    points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                                </polygon>
                                                <polygon id="Path-3" fill="url(#linearGradient-2)"
                                                    opacity="0.099999994"
                                                    points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288">
                                                </polygon>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <h2 class="brand-text text-primary ms-1">{{ config('app.name', 'Laravel') }}</h2>
                            </a>
                            @if (!empty($mensajes))
                                <div class="alert alert-warning" role="alert">
                                    <div class="alert-body">
                                        <span>{{ $mensajes }}</span></br>
                                    </div>
                                </div>
                            @endif

                            <form wire:submit="buscarDNI">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Numero de DNI"
                                        aria-describedby="button-addon2" wire:model='nroDocumento'>
                                    <button class="btn btn-outline-primary waves-effect" id="button-addon2"
                                        type="submit">Buscar</button>
                                </div>
                            </form>

                            <div class="{{ is_null($empleado->id) ? 'hidden' : '' }}">
                                <div class="input-group mb-2 mt-1">
                                    <span class="input-group-text" id="basic-addon-search1">
                                        Nombres
                                    </span>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $empleado->nombreCompleto() }}">
                                </div>

                                <form class="auth-login-form mt-2" wire:submit="guardar">
                                    <x-input-error for="permiso.empleadoId" />
                                    <x-input-error for="permiso.departamentoId" />
                                    <x-input-error for="permiso.servicioId" />
                                    
                                    <div class="mb-1">
                                        <label for="ipt-fundamento" class="form-label">Fundamento</label>
                                        <input type="text" class="form-control" id="ipt-fundamento"
                                            wire:model="permiso.fundamento" />
                                        <x-input-error for="permiso.fundamento" />

                                    </div>
                                    <div class="mb-1">
                                        <label for="ipt-destino" class="form-label">Destino</label>
                                        <input type="text" class="form-control" id="ipt-destino"
                                            wire:model="permiso.destino" />
                                        <x-input-error for="permiso.destino" />
                                    </div>
                                    <div class="mb-1">
                                        <label for="ipt-destino" class="form-label">Tipo</label>
                                        <select class="form-control" wire:model="permiso.tipoId">
                                            <option value="">- seleccione -</option>
                                            @foreach ($tipos as $item)
                                                <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="permiso.tipoId" />
                                    </div>
                                    <button class="btn btn-primary w-100" type="submit" tabindex="4">
                                        Registrar
                                    </button>
                                </form>
                            </div>
                            <a href='/' class="btn btn-info w-100 mt-1" type="button"
                                tabindex="4">Regresar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
