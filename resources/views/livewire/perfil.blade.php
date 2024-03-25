<x-content-body :title='$tituloPagina'>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mt-3 mb-2" src="{{ asset('images/profile/default.jpg') }}"
                                height="110" width="110" alt="User avatar">
                            <div class="user-info text-center">
                                <h4>{{ $empleado->nombreCompleto() }}</h4>
                                <span class="badge bg-light-secondary">{{ $empleado->cargo->descripcion }}</span>
                            </div>
                        </div>
                    </div>
                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Detalles</h4>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Usuario:</span>
                                <span>{{ $user->username }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Fecha de Nacimiento:</span>
                                <span>{{ date('d/m/Y', strtotime($empleado->fechaNacimiento)) }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Estado:</span>
                                <span class="badge bg-light-success">Activo</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Departamento:</span>
                                <span>{{ $empleado->departamento?->descripcion }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Servicio:</span>
                                <span>{{ $empleado->servicio?->descripcion }}</span>
                            </li>
                        </ul>
                        {{-- <div class="d-flex justify-content-center pt-2">
                            <a href="javascript:;" class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                data-bs-target="#editUser" data-bs-toggle="modal">
                                Edit
                            </a>
                            <a href="javascript:;"
                                class="btn btn-outline-danger suspend-user waves-effect">Suspended</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" id="security-tab-center" data-bs-toggle="pill"
                                href="#profile-center" aria-expanded="false">
                                <x-icon icon="lock" />
                                Seguridad
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile-center" role="tabpanel" aria-labelledby="security-tab-center" aria-expanded="false">
                            @if ($errors->any())
                                <div class="alert alert-danger mb-2" role="alert">
                                    <div class="alert-body fw-normal">          
                                    @foreach ($errors->all() as $error)
                                        <span>{{ $error }}</span><br>
                                    @endforeach
                                    </div>
                                </div>
                            @endif
                            <form id="formChangePassword" wire:submit="guardarContra" novalidate="novalidate">
                                <div class="row">
                                    <div class="mb-2 col-md-12 form-password-toggle">
                                        <label class="form-label" for="newPassword">Contraseña actual</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control" type="password" id="newPassword"
                                                name="newPassword" placeholder="············" wire:model="password">

                                            <span class="input-group-text cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-2 col-md-6 form-password-toggle">
                                        <label class="form-label" for="newPassword1">Nueva contraseña</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control" type="password" id="newPassword1"
                                                name="newPassword1" placeholder="············" wire:model="password1">
                                            <span class="input-group-text cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-2 col-md-6 form-password-toggle">
                                        <label class="form-label" for="confirmPassword">Confirma la nueva contraseña</label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control" type="password" name="confirmPassword"
                                                id="confirmPassword" placeholder="············" wire:model="password2">
                                            <span class="input-group-text cursor-pointer"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg></span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit"
                                            class="btn btn-primary me-2 waves-effect waves-float waves-light">
                                            Cambiar contraseña
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-content-body>
