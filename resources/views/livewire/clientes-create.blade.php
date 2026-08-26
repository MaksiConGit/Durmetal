<div>
    <x-layout2>
        <x-slot name="title">Nuevo cliente</x-slot>

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

                                <div class="form-group mb-2">
                                    <label for="TipoDocumento">Tipo de Documento</label>

                                    <select
                                        class="form-control form-control-sm"
                                        wire:model="TipoDocumento"
                                    >
                                        <option value="CUIT">CUIT</option>
                                        <option value="CUIL">CUIL</option>
                                    </select>
                                </div>

                                {{-- Retención IIBB --}}
                                <div class="form-group mb-2">
                                    <label>Calificación</label>

                                    <select
                                        class="form-control form-control-sm"
                                        wire:model="IdCalificacionCliente"
                                    >
                                        @foreach ($calificaciones_cliente as $calificacion_cliente)
                                            <option value="{{ $calificacion_cliente->id }}" {{ $calificacion_cliente->id == 1 ? 'selected' : '' }}>
                                                {{ $calificacion_cliente->Nombre }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('IdCalificacionCliente')
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
                                        <label>Código Postal</label>
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

                                {{-- CUIT --}}
                                <div class="form-group mb-2">
                                    <label>Número de Documento</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        wire:model="NumeroDocumento"
                                    >

                                    @error('NumeroDocumento')
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
                                        placeholder="cliente@cliente.com"
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
                                                {{ $localidad->Provincia?->Nombre ?? '' }}
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

{{-- <div>

    <x-layout2>
        <x-slot name="title">Nuevo cliente</x-slot>

        <form action="{{ route('clients.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-2"></div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="id" class="font-weight-normal">CODIGO</label>
                        <input type="text" id="id" name="id" class="form-control form-control-sm" value="{{old('id', $next_id)}}">
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="Nombre" class="font-weight-normal">NOMBRE</label>
                        <input type="text" id="Nombre" name="Nombre" class="form-control form-control-sm" value="{{old('Nombre')}}">
                    </div>
                </div>
                <div class="col-2 mb-3"></div>


                <div class="col-2 mb-3"></div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="Domicilio" class="font-weight-normal">DOMICILIO</label>
                        <input type="text" id="Domicilio" name="Domicilio" class="form-control form-control-sm" value="{{old('Domicilio')}}">
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="CP" class="font-weight-normal">CODIGO POSTAL</label>
                        <input type="text" id="CP" name="CP" class="form-control form-control-sm" wire:model.live="cp">
                    </div>
                </div>
                <div class="col-2 mb-3"></div>

                <div class="col-2 mb-3"></div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="IdLocalidad" class="font-weight-normal">LOCALIDAD</label>
                        <input type="text" id="IdLocalidad" name="IdLocalidad" class="form-control form-control-sm" value="{{ $cityName }}" disabled>
                        <input type="hidden" name="IdLocalidad" value="{{ $cityId }}">
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="" class="font-weight-normal">PROVINCIA</label>
                        <input type="text" id="" name="" class="form-control form-control-sm" value="{{ $provinceName }}" disabled>
                    </div>
                </div>
                <div class="col-2 mb-3"></div>


                <div class="col-2 mb-3"></div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="Telefono" class="font-weight-normal">TELEFONO</label>
                        <input type="text" id="Telefono" name="Telefono" class="form-control form-control-sm" value="{{old('Telefono')}}">
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="IdCondicionIVA" class="font-weight-normal">CONDICION IVA</label>
                        <select name="IdCondicionIVA" id="" class="form-control form-control-sm">
                            @foreach ($condiciones_IVA as $condicion_IVA)
                                <option value="{{ $condicion_IVA->id }}" {{$condicion_IVA->id == '1' ? 'selected' : ''}}>
                                    {{ $condicion_IVA->Nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2 mb-3"></div>

                <div class="col-2 mb-3"></div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="TipoDocumento" class="font-weight-normal">TIPO DOCUMENTO</label>
                        <select name="TipoDocumento" id="" class="form-control form-control-sm">
                            <option value="CUIT">CUIT</option>
                            <option value="CUIL">CUIL</option>
                        </select>
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="NroDocumento" class="font-weight-normal">NRO DOCUMENTO</label>
                        <input type="text" id="NroDocumento" name="NroDocumento" class="form-control form-control-sm" value="{{old('NroDocumemento')}}">
                    </div>
                </div>
                <div class="col-2 mb-3"></div>

                <div class="col-2 mb-3"></div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="IdCalificacionCliente" class="font-weight-normal">CALIFICACION</label>
                        <select name="IdCalificacionCliente" id="" class="form-control form-control-sm">
                            @foreach ($calificaciones_cliente as $calificacion_cliente)
                                <option value="{{ $calificacion_cliente->id }}" {{$calificacion_cliente->id == '1' ? 'selected' : ''}}>
                                    {{ $calificacion_cliente->Nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group mb-0">
                        <label for="Saldo" class="font-weight-normal">SALDO TRANSPORTADO</label>
                        <input type="text" id="Saldo" name="Saldo" class="form-control form-control-sm" value="{{old('Saldo')}}">
                    </div>
                </div>
                <div class="col-2 mb-3"></div>
                
                <div class="col-2 mb-3"></div>
                <div class="col-4 mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="hidden" name="Activo" value="0">
                        <input class="custom-control-input" type="checkbox" id="Activo" name="Activo" value="1">
                        <label for="Activo" class="custom-control-label">ACTIVO</label>
                    </div>
                </div>
                <div class="col-2 mb-3"></div>
                
            </div>
                
            <div class="row">
                <div class="col-2"></div>
                <div class="card col-8">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="" class="font-weight-normal">EMAILS</label>
                                    <input type="text" id="email1" name="emails[]" value="{{ old('emails.1') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-4 mb-3 mt-2">
                                <div class="form-group mb-0">
                                    <label for="email2" class="font-weight-normal"></label>
                                    <input type="text" id="email2" name="emails[]" value="{{ old('emails.2') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-4 mb-3 mt-2">
                                <div class="form-group mb-0">
                                    <label for="email2" class="font-weight-normal"></label>
                                    <input type="text" id="email2" name="emails[]" value="{{ old('emails.3') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="email3" class="font-weight-normal"></label>
                                    <input type="text" id="email3" name="emails[]" value="{{ old('emails.4') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="email4" class="font-weight-normal"></label>
                                    <input type="text" id="email4" name="emails[]" value="{{ old('emails.5') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="email4" class="font-weight-normal"></label>
                                    <input type="text" id="email4" name="emails[]" value="{{ old('emails.6') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="email5" class="font-weight-normal"></label>
                                    <input type="text" id="email5" name="emails[]" value="{{ old('emails.7') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="email6" class="font-weight-normal"></label>
                                    <input type="text" id="email6" name="emails[]" value="{{ old('emails.8') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="form-group mb-0">
                                    <label for="email6" class="font-weight-normal"></label>
                                    <input type="text" id="email6" name="emails[]" value="{{ old('emails.9') }}"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>

            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-app bg-primary">
                            <i class="fas fa-floppy-disk"></i> Guardar
                        </button>

                        <a class="btn btn-app bg-primary" href="{{ route('clients.index') }}">
                            <i class="fas fa-ban"></i> Cancelar
                        </a>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>

        </form>

    </x-layout2>

</div> --}}
