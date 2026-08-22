<div>
    <x-layout2>
        <x-slot name="title">Nuevo proveedor</x-slot>

        <div class="row">
            <div class="col-2"></div>

            <div class="col-8">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            {{-- Columna izquierda --}}
                            <div class="col-md-6">

                                {{-- Código --}}
                                <div class="form-group mb-2">
                                    <label>Código</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{ $next_id }}"
                                        disabled
                                    >
                                </div>

                                {{-- Domicilio --}}
                                <div class="form-group mb-2">
                                    <label>Domicilio</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        wire:model="Direccion"
                                    >

                                    @error('Direccion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Localidad --}}
                                <div class="form-group mb-2">
                                    <label>Localidad</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{ $localidad_nombre }}"
                                        disabled
                                    >

                                    @error('localidad_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Teléfono --}}
                                <div class="form-group mb-2">
                                    <label>Teléfono</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        wire:model="Telefono"
                                    >

                                    @error('Telefono')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- CUIT --}}
                                <div class="form-group mb-2">
                                    <label>CUIT</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        wire:model="NumeroDocumento"
                                    >

                                    @error('NumeroDocumento')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Retención IIBB --}}
                                <div class="form-group mb-2">
                                    <label>Retención IIBB</label>

                                    <select
                                        class="form-control form-control-sm"
                                        wire:model="IdRetencionIIBB"
                                    >
                                        <option value="0">No aplica</option>

                                        @foreach ($retenciones_IIBB as $r)
                                            <option value="{{ $r->id }}">
                                                {{ $r->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('IdRetencionIIBB')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Activo --}}
                                <div class="form-group mt-3">
                                    <label>
                                        <input
                                            type="checkbox"
                                            wire:model="Activo"
                                        >
                                        Activo
                                    </label>
                                </div>

                            </div>


                            {{-- Columna derecha --}}
                            <div class="col-md-6">

                                {{-- Nombre --}}
                                <div class="form-group mb-2">
                                    <label>Nombre</label>

                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        wire:model="Nombre"
                                    >

                                    @error('Nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                {{-- Código Postal --}}
                                <div class="mb-2">

                                    <div>
                                        <label>CÓDIGO POSTAL</label>
                                    </div>

                                    <div class="input-group">

                                        <input
                                            id="codigoPostal"
                                            class="form-control form-control-sm"
                                            type="text"
                                            value="{{ $codigo_postal }}"
                                            readonly
                                        >

                                        <div class="input-group-append">

                                            <button
                                                type="button"
                                                class="btn btn-sidebar btn-sm bg-orange"
                                                data-toggle="modal"
                                                data-target="#modal-cliente"
                                            >
                                                <i class="fas fa-search fa-fw text-white"></i>
                                            </button>

                                        </div>

                                    </div>

                                </div>


                                {{-- Provincia --}}
                                <div class="form-group mb-2">
                                    <label>Provincia</label>

                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{ $provincia_nombre }}"
                                        disabled
                                    >
                                </div>


                                {{-- Condición IVA --}}
                                <div class="form-group mb-2">
                                    <label>Condición IVA</label>

                                    <select
                                        class="form-control form-control-sm"
                                        wire:model="IdCondicionIva"
                                    >
                                        @foreach ($condiciones_IVA as $c)
                                            <option value="{{ $c->id }}">
                                                {{ $c->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('IdCondicionIva')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                {{-- Saldo Transportado --}}
                                <div class="form-group mb-2">
                                    <label>Saldo Transportado</label>

                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        wire:model="Saldo"
                                        placeholder="0.00"
                                    >

                                    @error('Saldo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                {{-- Número Documento IIBB --}}
                                <div class="form-group mb-2">
                                    <label>N° Documento IIBB</label>

                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        wire:model="NumeroIIBB"
                                    >

                                    @error('NumeroIIBB')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                {{-- Cuenta de Gastos --}}
                                <div class="form-group mb-2">
                                    <label>Cuenta de Gastos</label>

                                    <select
                                        class="form-control form-control-sm"
                                        wire:model="IdCuentaGastos"
                                    >
                                        @foreach ($cuentas_de_gastos as $c)
                                            <option value="{{ $c->id }}">
                                                {{ $c->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('IdCuentaGastos')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                        </div>


                        {{-- Emails --}}
                        <div class="row justify-content-center mt-4">

                            @for ($i = 0; $i < 6; $i++)

                                <div class="col-4 mb-2">

                                    <input
                                        type="text"
                                        wire:model="emails.{{ $i }}"
                                        class="form-control form-control-sm"
                                        placeholder="proveedor@proveedor.com"
                                    >

                                    @error("emails.$i")
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>

                            @endfor

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-2"></div>
        </div>


        {{-- Botones --}}
        <div class="row mt-3">

            <div class="col-2"></div>

            <div class="col-8 d-flex justify-content-end">

                {{-- Guardar --}}
                <button
                    type="button"
                    class="btn btn-app bg-primary"
                    wire:click="guardar"
                    wire:loading.attr="disabled"
                    wire:target="guardar"
                >
                    <i class="fas fa-floppy-disk"></i>

                    <span wire:loading.remove wire:target="guardar">
                        Guardar
                    </span>

                    <span wire:loading wire:target="guardar">
                        Guardando...
                    </span>
                </button>


                {{-- Cancelar --}}
                <a
                    class="btn btn-app bg-danger"
                    href="{{ route('compras.actualizaciones.proveedores.index') }}"
                >
                    <i class="fas fa-ban"></i>
                    Cancelar
                </a>

            </div>

            <div class="col-2"></div>

        </div>


        {{-- ========================================================= --}}
        {{-- MODAL CÓDIGO POSTAL --}}
        {{-- ========================================================= --}}

        <div
            class="modal fade"
            id="modal-cliente"
            wire:ignore.self
        >

            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content">

                    {{-- Header --}}
                    <div class="modal-header">

                        <h5 class="modal-title">
                            BUSCAR CÓDIGO POSTAL
                        </h5>

                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>


                    {{-- Body --}}
                    <div class="modal-body">

                        <div class="row">

                            <x-simple-table2>

                                {{-- Filtros --}}
                                <x-slot name="filtros">

                                    <div class="row">

                                        {{-- Localidad --}}
                                        <div class="col-3">

                                            <div class="form-group mb-0">

                                                <label
                                                    for="filtro1"
                                                    class="font-weight-normal"
                                                >
                                                    LOCALIDAD
                                                </label>

                                                <input
                                                    id="filtro1"
                                                    type="text"
                                                    wire:model.live="searchLocalidad"
                                                    class="form-control form-control-sm"
                                                    placeholder="Buscar localidad..."
                                                    autocomplete="off"
                                                >

                                            </div>

                                        </div>


                                        {{-- Código Postal --}}
                                        <div class="col-3">

                                            <div class="form-group mb-0">

                                                <label
                                                    for="filtro2"
                                                    class="font-weight-normal"
                                                >
                                                    CP
                                                </label>

                                                <input
                                                    id="filtro2"
                                                    type="text"
                                                    wire:model.live="searchCP"
                                                    class="form-control form-control-sm"
                                                    placeholder="Buscar CP..."
                                                    autocomplete="off"
                                                >

                                            </div>

                                        </div>


                                        {{-- Provincia --}}
                                        <div class="col-3">

                                            <div class="form-group mb-0">

                                                <label
                                                    for="filtro3"
                                                    class="font-weight-normal"
                                                >
                                                    PROVINCIA
                                                </label>

                                                <input
                                                    id="filtro3"
                                                    type="text"
                                                    wire:model.live="searchProvincia"
                                                    class="form-control form-control-sm"
                                                    placeholder="Buscar provincia..."
                                                    autocomplete="off"
                                                >

                                            </div>

                                        </div>

                                    </div>

                                </x-slot>


                                {{-- Cabecera tabla --}}
                                <x-slot name="thead">

                                    <tr>
                                        <th>LOCALIDAD</th>
                                        <th>CP</th>
                                        <th>PROVINCIA</th>
                                    </tr>

                                </x-slot>


                                {{-- Cuerpo tabla --}}
                                <x-slot name="tbody">

                                    @forelse ($this->localidadesFiltradas as $localidad)

                                        <tr
                                            wire:key="localidad-{{ $localidad->id }}"
                                            wire:click="seleccionarLocalidad({{ $localidad->id }})"
                                            data-dismiss="modal"
                                            style="cursor:pointer;"
                                        >

                                            <td>
                                                {{ $localidad->Nombre }}
                                            </td>

                                            <td>
                                                {{ $localidad->CP }}
                                            </td>

                                            <td>
                                                {{ $localidad->provincia?->Nombre ?? '' }}
                                            </td>

                                        </tr>

                                    @empty

                                        @if (
                                            $searchLocalidad !== '' ||
                                            $searchCP !== '' ||
                                            $searchProvincia !== ''
                                        )

                                            <tr>

                                                <td colspan="3">
                                                    No se encontraron resultados.
                                                </td>

                                            </tr>

                                        @endif

                                    @endforelse

                                </x-slot>

                            </x-simple-table2>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="modal-footer justify-content-end">

                        <button
                            type="button"
                            class="btn btn-sidebar btn-sm bg-orange"
                            data-dismiss="modal"
                        >
                            <span class="text-white">
                                Aceptar
                            </span>

                            <i class="fas fa-check fa-fw text-white ml-2"></i>
                        </button>

                        <button
                            type="button"
                            class="btn btn-sidebar btn-sm bg-orange"
                            data-dismiss="modal"
                            wire:click="cancelarCliente"
                        >
                            <span class="text-white">
                                Cancelar
                            </span>

                            <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </x-layout2>
</div>