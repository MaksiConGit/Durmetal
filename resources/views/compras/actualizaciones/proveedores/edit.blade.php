<x-layout2>
    <x-slot name="title">Editar proveedor</x-slot>

    <form action="{{ route('compras.actualizaciones.proveedores.update', $proveedor) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-2"></div>

            <div class="col-8">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            {{-- IZQUIERDA --}}
                            <div class="col-md-6">

                                <div class="form-group mb-2">
                                    <label>Código</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $proveedor->id }}" disabled>
                                </div>

                                <div class="form-group mb-2">
                                    <label>Domicilio</label>
                                    <input type="text" name="Direccion"
                                        class="form-control form-control-sm"
                                        value="{{ old('Direccion', $proveedor->Direccion) }}">
                                </div>

                                @livewire('localidad-edit', ['initialCityId' => $proveedor->IdLocalidad])

                                <div class="form-group mb-2">
                                    <label>Teléfono</label>
                                    <input type="text" name="Telefono"
                                        class="form-control form-control-sm"
                                        value="{{ old('Telefono', $proveedor->Telefono) }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>CUIT</label>
                                    <input type="text" name="NumeroDocumento"
                                        class="form-control form-control-sm"
                                        value="{{ old('NumeroDocumento', $proveedor->NumeroDocumento) }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>Retención IIBB</label>
                                    <select name="IdRetencionIIBB" class="form-control form-control-sm">
                                        <option value="">No aplica</option>
                                        @foreach ($retenciones_IIBB as $r)
                                            <option value="{{ $r->id }}"
                                                {{ $r->id == $proveedor->IdRetencionIIBB ? 'selected' : '' }}>
                                                {{ $r->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <input type="hidden" name="Activo" value="0">
                                    <label>
                                        <input type="checkbox" name="Activo" value="1"
                                            {{ old('Activo', $proveedor->Activo) ? 'checked' : '' }}>
                                        Activo
                                    </label>
                                </div>

                            </div>

                            {{-- DERECHA --}}
                            <div class="col-md-6">

                                <div class="form-group mb-2">
                                    <label>Nombre</label>
                                    <input type="text" name="Nombre"
                                        class="form-control form-control-sm"
                                        value="{{ old('Nombre', $proveedor->Nombre) }}">
                                </div>

                                @livewire('codigo-postal-provincia-edit', ['initialCityId' => $proveedor->IdLocalidad])

                                <div class="form-group mb-2">
                                    <label>Condición IVA</label>
                                    <select name="IdCondicionIva" class="form-control form-control-sm">
                                        @foreach ($condiciones_IVA as $c)
                                            <option value="{{ $c->id }}"
                                                {{ $c->id == $proveedor->condicionIVA->id ? 'selected' : '' }}>
                                                {{ $c->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label>Saldo Transportado</label>
                                    <input type="text" name="Saldo"
                                        class="form-control form-control-sm"
                                        value="{{ old('Saldo', $proveedor->Saldo) }}"
                                        placeholder="0.00">
                                </div>

                                <div class="form-group mb-2">
                                    <label>N° Documento IIBB</label>
                                    <input type="text" name="NumeroIIBB"
                                        class="form-control form-control-sm"
                                        value="{{ old('NumeroIIBB', $proveedor->NumeroIIBB) }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>Cuenta de Gastos</label>
                                    <select name="IdCuentaGastos" class="form-control form-control-sm">
                                        @foreach ($cuentas_de_gastos as $c)
                                            <option value="{{ $c->id }}"
                                                {{ $c->id == $proveedor->IdCuentaGastos ? 'selected' : '' }}>
                                                {{ $c->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>

                        {{-- EMAILS --}}
                        <div class="row justify-content-center mt-3">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="col-4 mb-2">
                                    <input type="text"
                                        name="emails[]"
                                        value="{{ $oldEmails[$i] ?? '' }}"
                                        class="form-control form-control-sm"
                                        placeholder="proveedor@proveedor.com">
                                </div>
                            @endfor
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-2"></div>
        </div>

        {{-- BOTONES --}}
        <div class="row mt-3">
            <div class="col-2"></div>

            <div class="col-8 d-flex justify-content-end">
                <button class="btn btn-app bg-primary">
                    <i class="fas fa-floppy-disk"></i> Guardar
                </button>

                <a class="btn btn-app bg-danger"
                    href="{{ route('compras.actualizaciones.proveedores.index') }}">
                    <i class="fas fa-ban"></i> Cancelar
                </a>
            </div>

            <div class="col-2"></div>
        </div>

    </form>
</x-layout2>