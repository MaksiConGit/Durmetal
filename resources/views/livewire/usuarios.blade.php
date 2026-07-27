<div>
    <style>
.password-btn {
    color: white !important;
    border-left: 1px solid white !important;
    position: relative;
}

.password-btn i {
    color: white !important;
}

.password-btn:hover {
    color: white !important;
}

        .password-btn:first-child {
            border-left: none !important;
        }

        .password-tooltip {
            position: absolute;
            bottom: 42px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
            white-space: nowrap;
            z-index: 9999;
        }

        .password-tooltip::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }
    </style>
        <div x-data="{ selected: @entangle('selectedItem') }">

    <x-layout2-sidebar>
        <x-slot name="title">Usuarios</x-slot>

        <x-slot name="filtros">
            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                    <a class="btn btn-app bg-primary" data-toggle="modal" data-target="#modal-create">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>

                <div class="form-group mb-3">
                    <a 
                        class="btn btn-app bg-primary"
                        :class="!selected ? 'disabled' : ''"
                        @click="if (!selected) return"
                        data-toggle="modal" 
                        data-target="#modal-edit"
                        wire:click="editarUsuario(selected)"
                    >
                        <i class="fas fa-pen"></i> Modificar
                    </a>
                </div>


                <div class="form-group mb-3">
                    <button
                        type="button"
                        class="btn btn-app bg-primary"
                        :class="!selected ? 'disabled' : ''"
                        @click="
                            if (!selected) return;
                            if (confirm('¿Estás seguro que deseas eliminar este usuario?')) {
                                $wire.eliminarUsuario(selected)
                            }
                        "
                    >
                        <i class="fas fa-trash-can"></i> Eliminar
                    </button>
                </div>
                                                
            </div>

        </x-slot>


            <x-simple-table2>
                <x-slot name="thead">
                    <tr>
                        <th>USUARIO</th>
                        <th>NOMBRE COMPLETO</th>
                        <th>PERMISOS</th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    @forelse ($usuarios as $usuario_)
                        <tr 
                            style="cursor: pointer;"
                            @click="selected = {{ $usuario_->id }}"
                            wire:click="seleccionarUsuario({{ $usuario_->id }})"
                            :class="selected === {{ $usuario_->id }} ? 'table-primary' : ''"
                        >
                            <td>{{ $usuario_->Usuario }}</td>
                            <td>{{ $usuario_->Nombre }}</td>
                            <td>
                                {{ $usuario_->getRoleNames()->implode(', ') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No hay usuarios registrados</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-simple-table2>
    </x-layout2-sidebar>
    </div>


    <!-- .modal -->
    <div class="modal fade" id="modal-create" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        NUEVO USUARIO
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- USUARIO + NOMBRE -->
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal">
                                    USUARIO
                                </label>

                                <input 
                                    type="text"
                                    class="form-control form-control-sm @error('Usuario') is-invalid @enderror"
                                    wire:model.live="Usuario">

                                @error('Usuario')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal">
                                    NOMBRE COMPLETO
                                </label>

                                <input 
                                    type="text"
                                    class="form-control form-control-sm @error('Nombre') is-invalid @enderror"
                                    wire:model.live="Nombre">

                                @error('Nombre')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                    </div>

                    <!-- ROL + CONTRASEÑA -->
                    <div class="row mt-3">

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal">
                                    ROL
                                </label>

                                <select 
                                    class="form-control form-control-sm @error('Rol') is-invalid @enderror"
                                    wire:model.live="Rol">

                                    <option value="" hidden>
                                        Seleccione un rol
                                    </option>

                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}">
                                            {{ $rol->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('Rol')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-6">

                            <div class="form-group mb-0" x-data="{ mostrar: false }">

                                <label class="font-weight-normal">
                                    CONTRASEÑA
                                </label>

                                <div class="input-group input-group-sm">

                                    <input 
                                        :type="mostrar ? 'text' : 'password'"
                                        class="form-control form-control-sm @error('Contraseña') is-invalid @enderror"
                                        wire:model.live="Contraseña"
                                        id="Contraseña">

                                    <div class="input-group-append">

                                        <button 
                                            type="button"
                                            class="btn bg-orange password-btn"
                                            title="Mostrar / ocultar contraseña"
                                            @click="mostrar = !mostrar">

                                            <i class="fas"
                                            :class="mostrar ? 'fa-eye-slash' : 'fa-eye'">
                                            </i>

                                        </button>

                                        <button 
                                            type="button"
                                            class="btn bg-orange password-btn"
                                            title="Generar contraseña"
                                            onclick="generarPassword(); mostrarMensaje(this,'Contraseña generada')">

                                            <i class="fas fa-key"></i>

                                        </button>

                                    </div>

                                    @error('Contraseña')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- COBRA PREMIO + INDICE -->
                    <div class="row mt-3">

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal d-block" for="premio" style="user-select: none; cursor: pointer;">
                                    COBRA PREMIO
                                </label>

                                <input 
                                    id="premio"
                                    type="checkbox"
                                    wire:model.live="CobraPremio"
                                    style="user-select: none; cursor: pointer;">

                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal">
                                    ÍNDICE BASE PREMIO
                                </label>

                                <input 
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="form-control form-control-sm @error('IndiceBasePremio') is-invalid @enderror"
                                    wire:model.live="IndiceBasePremio"
                                    @disabled(!$CobraPremio)>

                                @error('IndiceBasePremio')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer justify-content-end">

                    <button 
                        type="button"
                        wire:click="guardarUsuario"
                        class="btn btn-sidebar btn-sm bg-orange">

                        <span class="text-white">
                            Guardar
                        </span>

                        <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>

                    </button>

                    <button 
                        type="button"
                        class="btn btn-sidebar btn-sm bg-orange"
                        data-dismiss="modal">

                        <span class="text-white">
                            Cancelar
                        </span>

                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>

                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- .modal -->
    <div class="modal fade" id="modal-edit" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        EDITAR USUARIO
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- USUARIO + NOMBRE -->
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal">
                                    USUARIO
                                </label>

                                <input 
                                    type="text"
                                    class="form-control form-control-sm @error('editUsuario') is-invalid @enderror"
                                    wire:model.live="editUsuario">

                                @error('editUsuario')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal">
                                    NOMBRE COMPLETO
                                </label>

                                <input 
                                    type="text"
                                    class="form-control form-control-sm @error('editNombre') is-invalid @enderror"
                                    wire:model.live="editNombre">

                                @error('editNombre')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                    </div>

                    <!-- ROL + CONTRASEÑA -->
                    <div class="row mt-3">

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal">
                                    ROL
                                </label>

                                <select 
                                    class="form-control form-control-sm @error('editRol') is-invalid @enderror"
                                    wire:model.live="editRol">

                                    <option value="" hidden>
                                        Seleccione un rol
                                    </option>

                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}">
                                            {{ $rol->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('editRol')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-6">

                            <div class="form-group mb-0" x-data="{ mostrar: false }">

                                <label class="font-weight-normal">
                                    CONTRASEÑA
                                </label>

                                <div class="input-group input-group-sm">

                                    <input 
                                        :type="mostrar ? 'text' : 'password'"
                                        class="form-control form-control-sm @error('editContraseña') is-invalid @enderror"
                                        wire:model.live="editContraseña"
                                        id="editContraseña">

                                    <div class="input-group-append">

                                        <button 
                                            type="button"
                                            class="btn bg-orange password-btn"
                                            title="Mostrar / ocultar contraseña"
                                            @click="mostrar = !mostrar">

                                            <i class="fas"
                                            :class="mostrar ? 'fa-eye-slash' : 'fa-eye'">
                                            </i>

                                        </button>

                                    </div>
                                    

                                    
                                    @error('editContraseña')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                                                    <small class="form-text text-muted">
                                        Dejar vacío para mantener la contraseña actual
                                    </small>

                            </div>
                        </div>

                    </div>

                    <!-- COBRA PREMIO + INDICE -->
                    <div class="row mt-3">

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal d-block" for="editPremio" style="user-select: none; cursor: pointer;">
                                    COBRA PREMIO
                                </label>

                                <input 
                                    id="editPremio"
                                    type="checkbox"
                                    wire:model.live="editCobraPremio"
                                    style="user-select: none; cursor: pointer;">

                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group mb-0">

                                <label class="font-weight-normal">
                                    ÍNDICE BASE PREMIO
                                </label>

                                <input 
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="form-control form-control-sm @error('editIndiceBasePremio') is-invalid @enderror"
                                    wire:model.live="editIndiceBasePremio"
                                    @disabled(!$editCobraPremio)>

                                @error('editIndiceBasePremio')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer justify-content-end">

                    <button 
                        type="button"
                        wire:click="editarUsuario"
                        class="btn btn-sidebar btn-sm bg-orange">

                        <span class="text-white">
                            Guardar
                        </span>

                        <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>

                    </button>

                    <button 
                        type="button"
                        class="btn btn-sidebar btn-sm bg-orange"
                        data-dismiss="modal">

                        <span class="text-white">
                            Cancelar
                        </span>

                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>

                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->


    @if ($errors->any() && session('modal') == 'create')
        <script>$('#modal-create').modal('show');</script>
    @endif

    @if ($errors->any() && session('modal') == 'edit')
        <script>$('#modal-edit').modal('show');</script>
    @endif

    <script>

        function generarPassword()
        {
            const caracteres = 
                'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

            let password = '';

            for(let i = 0; i < 8; i++)
            {
                password += caracteres.charAt(
                    Math.floor(Math.random() * caracteres.length)
                );
            }


            document.getElementById('Contraseña').value = password;


            document.getElementById('Contraseña')
                .dispatchEvent(new Event('input'));
        }

        function mostrarMensaje(boton, texto)
        {
            document.querySelectorAll('.password-tooltip').forEach(t => {
                t.remove();
            });


            let tooltip = document.createElement('span');

            tooltip.className = 'password-tooltip';
            tooltip.innerHTML = texto;


            boton.appendChild(tooltip);


            setTimeout(() => {
                tooltip.remove();
            }, 1500);
        }

    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('usuarioCreado', () => {
                $('#modal-create').modal('hide');
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('usuarioEditado', () => {
                $('#modal-edit').modal('hide');
            });
        });
    </script>
    
</div>
