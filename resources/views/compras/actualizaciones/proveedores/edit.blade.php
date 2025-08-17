
<x-layout>

    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Proveedores</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Editar Proveedor</a></li>
    </x-slot>

    <x-form>

        <x-slot name="card_title">Editar Proveedor</x-slot>
        <x-slot name="action">{{ route('compras.actualizaciones.proveedores.update', $proveedor) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-6 mb-3">
                <x-form-input-disabled>
                    <x-slot name="label">Código</x-slot>
                    <x-slot name="name">id</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('id', $proveedor->id)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('id'))
                            {{ $errors->first('id') }}
                        @elseif (old('id'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('id'))
                          is-invalid
                      @elseif (old('id') && ! $errors->has('id'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-disabled>
                            
                <x-form-input-default>
                    <x-slot name="label">Domicilio</x-slot>
                    <x-slot name="name">Direccion</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Direccion', $proveedor->Direccion)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Direccion'))
                            {{ $errors->first('Direccion') }}
                        @elseif (old('Direccion'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('Direccion'))
                          is-invalid
                      @elseif (old('Direccion') && ! $errors->has('Direccion'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-default>

                @livewire('localidad-edit', ['initialCityId' => $proveedor->IdLocalidad])

                <x-form-input-default>
                    <x-slot name="label">Teléfono</x-slot>
                    <x-slot name="name">Telefono</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Telefono', $proveedor->Telefono)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Telefono'))
                            {{ $errors->first('Telefono') }}
                        @elseif (old('Telefono'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('Telefono'))
                          is-invalid
                      @elseif (old('Telefono') && ! $errors->has('Telefono'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-default>

                <x-form-input-default>
                    <x-slot name="label">CUIT</x-slot>
                    <x-slot name="name">NumeroDocumento</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('NumeroDocumento', $proveedor->NumeroDocumento)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('NumeroDocumento'))
                            {{ $errors->first('NumeroDocumento') }}
                        @elseif (old('NumeroDocumento'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('NumeroDocumento'))
                          is-invalid
                      @elseif (old('NumeroDocumento') && ! $errors->has('NumeroDocumento'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-default>

                <x-form-input-select>
                    <x-slot name="label">Retención IIBB</x-slot>
                    <x-slot name="name">IdRetencionIIBB</x-slot>
                    <x-slot name="option">
                        <option value="">No aplica</option>
                        @foreach ($retenciones_IIBB as $retencion_IIBB)
                            <option value="{{ $retencion_IIBB->id }}" {{$retencion_IIBB->id == $proveedor->IdRetencionIIBB ? 'selected' : ''}}>
                                {{ $retencion_IIBB->Nombre }}
                            </option>
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('IdRetencionIIBB'))
                            {{ $errors->first('IdRetencionIIBB') }}
                        @elseif (old('IdRetencionIIBB'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('IdRetencionIIBB'))
                          is-invalid
                      @elseif (old('IdRetencionIIBB') && ! $errors->has('IdRetencionIIBB'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-select>

                <input type="hidden" name="Activo" value="0">
                <x-form-input-checkbox>
                    <x-slot name="label">Activo</x-slot>
                    <x-slot name="name">Activo</x-slot>
                    <x-slot name="value">1</x-slot>
                    <x-slot name="color">black</x-slot>
                    <x-slot name="checked">{{ old('Activo', $proveedor->Activo) ? 'checked' : '' }}</x-slot>
                </x-form-input-checkbox>
            </div>

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">Nombre</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Nombre', $proveedor->Nombre)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Nombre'))
                            {{ $errors->first('Nombre') }}
                        @elseif (old('Nombre'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('Nombre'))
                          is-invalid
                      @elseif (old('Nombre') && ! $errors->has('Nombre'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-default>

                @livewire('codigo-postal-provincia-edit', ['initialCityId' => $proveedor->IdLocalidad])

                <x-form-input-select>
                    <x-slot name="label">Condición IVA</x-slot>
                    <x-slot name="name">IdCondicionIVA</x-slot>
                    <x-slot name="option">
                        @foreach ($condiciones_IVA as $condicion_IVA)
                            <option value="{{ $condicion_IVA->id }}" {{$condicion_IVA->id == $proveedor->condicionIVA->id ? 'selected' : ''}}>
                                {{ $condicion_IVA->Nombre }}
                            </option>
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('IdCondicionIVA'))
                            {{ $errors->first('IdCondicionIVA') }}
                        @elseif (old('IdCondicionIVA'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('IdCondicionIVA'))
                          is-invalid
                      @elseif (old('IdCondicionIVA') && ! $errors->has('IdCondicionIVA'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-select>

                <x-form-input-default>
                    <x-slot name="label">Saldo Transportado</x-slot>
                    <x-slot name="name">Saldo</x-slot>
                    <x-slot name="placeholder">0.00</x-slot>
                    <x-slot name="value">{{old('Saldo')}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Saldo'))
                            {{ $errors->first('Saldo') }}
                        @elseif (old('Saldo'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('Saldo'))
                          is-invalid
                      @elseif (old('Saldo') && ! $errors->has('Saldo'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-default>

                <x-form-input-default>
                    <x-slot name="label">N° Documento IIBB</x-slot>
                    <x-slot name="name">NumeroIIBB</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('NumeroIIBB', $proveedor->NumeroIIBB)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('NumeroIIBB'))
                            {{ $errors->first('NumeroIIBB') }}
                        @elseif (old('NumeroIIBB'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('NumeroIIBB'))
                          is-invalid
                      @elseif (old('NumeroIIBB') && ! $errors->has('NumeroIIBB'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-default>

                <x-form-input-select>
                    <x-slot name="label">Cuenta de Gastos</x-slot>
                    <x-slot name="name">IdCuentaGastos</x-slot>
                    <x-slot name="option">
                        @foreach ($cuentas_de_gastos as $cuenta_de_gastos)
                            <option value="{{ $cuenta_de_gastos->id }}" {{$cuenta_de_gastos->id == $proveedor->IdCuentaGastos ? 'selected' : ''}}>
                                {{ $cuenta_de_gastos->Nombre }}
                            </option>
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('IdCuentaGastos'))
                            {{ $errors->first('IdCuentaGastos') }}
                        @elseif (old('IdCuentaGastos'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('IdCuentaGastos'))
                          is-invalid
                      @elseif (old('IdCuentaGastos') && ! $errors->has('IdCuentaGastos'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-select>

            </div>


            {{-- Emails --}}
            <div class="col-md-6 mb-3">
            @for ($i = 0; $i < 3; $i++)
                <x-form-input-email>
                    <x-slot name="label">{{ $i == 0 ? 'Email' : '' }}</x-slot>
                    <x-slot name="name">emails[]</x-slot>
                    <x-slot name="placeholder">proveedor@proveedor.com</x-slot>
                    <x-slot name="value">{{ $oldEmails[$i] ?? '' }}</x-slot>
                </x-form-input-email>
            @endfor
            </div>

            <div class="col-md-6 mb-3">
            @for ($i = 3; $i < 6; $i++)
                <x-form-input-email>
                    <x-slot name="label">{{ $i == 3 ? '-' : '' }}</x-slot>
                    <x-slot name="name">emails[]</x-slot>
                    <x-slot name="placeholder">proveedor@proveedor.com</x-slot>
                    <x-slot name="value">{{ $oldEmails[$i] ?? '' }}</x-slot>
                </x-form-input-email>
            @endfor
            </div>

        </x-slot>
        <x-slot name="buttons">
            <x-form-button>
                <x-slot name="text">Editar</x-slot>
                <x-slot name="color">success</x-slot>
            </x-form-button>
            <x-button>
                <x-slot name="text">Volver</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('compras.actualizaciones.proveedores.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>
</x-layout>