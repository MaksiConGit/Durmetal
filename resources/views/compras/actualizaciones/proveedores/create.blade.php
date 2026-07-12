<x-layout2>
    <x-slot name="title">Nuevo proveedor</x-slot>

    <form action="{{ route('compras.actualizaciones.proveedores.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-2"></div>

            <div class="col-8">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            {{-- Columna izquierda --}}
                            <div class="col-md-6">

                                <div class="form-group mb-2">
                                    <label>Código</label>
                                    <input type="text" class="form-control form-control-sm" 
                                        value="{{ old('id', $next_id) }}" disabled>
                                </div>

                                <div class="form-group mb-2">
                                    <label>Domicilio</label>
                                    <input type="text" name="Direccion" class="form-control form-control-sm"
                                        value="{{ old('Direccion') }}">
                                </div>

                                @livewire('localidad')

                                <div class="form-group mb-2">
                                    <label>Teléfono</label>
                                    <input type="text" name="Telefono" class="form-control form-control-sm"
                                        value="{{ old('Telefono') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>CUIT</label>
                                    <input type="text" name="NumeroDocumento" class="form-control form-control-sm"
                                        value="{{ old('NumeroDocumento') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>Retención IIBB</label>
                                    <select name="IdRetencionIIBB" class="form-control form-control-sm">
                                        <option value="">No aplica</option>
                                        @foreach ($retenciones_IIBB as $r)
                                            <option value="{{ $r->id }}">{{ $r->Nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <input type="hidden" name="Activo" value="0">
                                    <label>
                                        <input type="checkbox" name="Activo" value="1" checked> Activo
                                    </label>
                                </div>

                            </div>

                            {{-- Columna derecha --}}
                            <div class="col-md-6">

                                <div class="form-group mb-2">
                                    <label>Nombre</label>
                                    <input type="text" name="Nombre" class="form-control form-control-sm"
                                        value="{{ old('Nombre') }}">
                                </div>

                                @livewire('codigo-postal-provincia')

                                <div class="form-group mb-2">
                                    <label>Condición IVA</label>
                                    <select name="IdCondicionIva" class="form-control form-control-sm">
                                        @foreach ($condiciones_IVA as $c)
                                            <option value="{{ $c->id }}" {{ $c->id == 1 ? 'selected' : '' }}>
                                                {{ $c->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label>Saldo Transportado</label>
                                    <input type="text" name="Saldo" class="form-control form-control-sm"
                                        value="{{ old('Saldo') }}" placeholder="0.00">
                                </div>

                                <div class="form-group mb-2">
                                    <label>N° Documento IIBB</label>
                                    <input type="text" name="NumeroIIBB" class="form-control form-control-sm"
                                        value="{{ old('NumeroIIBB') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>Cuenta de Gastos</label>
                                    <select name="IdCuentaGastos" class="form-control form-control-sm">
                                        @foreach ($cuentas_de_gastos as $c)
                                            <option value="{{ $c->id }}" {{ $c->id == 1 ? 'selected' : '' }}>
                                                {{ $c->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>

                        {{-- Emails --}}
                        <div class="row justify-content-center mt-3">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="col-4 mb-2">
                                    <input type="text" name="emails[]" 
                                        value="{{ old('emails.' . $i) }}"
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

        {{-- Botones --}}
        <div class="row mt-3">
            <div class="col-2"></div>

            <div class="col-8 d-flex justify-content-end">
                <button class="btn btn-app bg-primary">
                    <i class="fas fa-floppy-disk"></i> Guardar
                </button>

                <a class="btn btn-app bg-danger" href="{{ route('compras.actualizaciones.proveedores.index') }}">
                    <i class="fas fa-ban"></i> Cancelar
                </a>
            </div>

            <div class="col-2"></div>
        </div>

    </form>

</x-layout2>