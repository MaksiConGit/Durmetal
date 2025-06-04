<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ingreso de materiales</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Añadir Item de Orden de Trabajo</a></li>
    </x-slot>

    <div class="col-md-4 mb-3">
        <x-form-input-select-disabled>
            <x-slot name="label">Punto de Venta</x-slot>
            <x-slot name="name">PuntoVenta</x-slot>
            <x-slot name="option">
                @foreach ($pto_ventas as $pto_venta)
                    <option value="{{$pto_venta->id}}" {{$pto_venta->id == $punto_venta ? 'selected' : ''}}>{{$pto_venta->Nombre}}</option>                            
                @endforeach
            </x-slot>
            <x-slot name="message"></x-slot>
            <x-slot name="error"></x-slot>
        </x-form-input-select-disabled>

        <x-form-input-select-disabled>
            <x-slot name="label">Código Cliente</x-slot>
            <x-slot name="name">IdCliente</x-slot>
            <x-slot name="option">
                @foreach ($clientes as $cliente)
                    <option value="{{$cliente->id}}" {{$cliente->id == $id_cliente ? 'selected' : ''}}>{{$cliente->id}} | {{$cliente->Nombre}}</option>                            
                @endforeach
            </x-slot>
            <x-slot name="message"></x-slot>
            <x-slot name="error"></x-slot>
        </x-form-input-select-disabled>
    </div>

    <div class="col-md-4 mb-3">
        <x-form-input-disabled>
            <x-slot name="label">Número</x-slot>
            <x-slot name="name">Numero</x-slot>
            <x-slot name="placeholder"></x-slot>
            <x-slot name="value">{{old('Numero', $numero)}}</x-slot>
        <x-slot name="message"></x-slot>
        <x-slot name="error"></x-slot>
        </x-form-input-disabled>

        <x-form-input-date-disabled>
            <x-slot name="label">Fecha de Emisión</x-slot>
            <x-slot name="name">FechaEmision</x-slot>
            <x-slot name="value">{{old('FechaEmision', $fecha_emision)}}</x-slot>
        </x-form-input-date-disabled>
    </div>

    <div class="col-md-4 mb-3">
        <x-form-input-disabled>
        <x-slot name="label">N° Remito Cliente</x-slot>
        <x-slot name="name">NumeroRemitoCliente</x-slot>
        <x-slot name="placeholder"></x-slot>
        <x-slot name="value">{{old('NumeroRemitoCliente', $numero_remito_cliente)}}</x-slot>
        <x-slot name="message"></x-slot>
        <x-slot name="error"></x-slot>
        </x-form-input-disabled>
    </div>

    <x-form>
        <x-slot name="card_title">Añadir Item de Orden de Trabajo</x-slot>
        <x-slot name="action">{{ route('item-orden-trabajo.store', $orden_trabajo->id) }}</x-slot>
        <x-slot name="method"></x-slot>

        <x-slot name="inputs">

            <div class="col-md-4 mb-3">

                <input type="hidden" name="IdOrdenTrabajo" value="{{$orden_trabajo->id}}">
                <input type="hidden" name="PuntoVenta" value="{{ $punto_venta }}">
                <input type="hidden" name="IdCliente" value="{{ $id_cliente }}">
                <input type="hidden" name="Numero" value="{{ $numero }}">
                <input type="hidden" name="FechaEmision" value="{{ $fecha_emision }}">
                <input type="hidden" name="NumeroRemitoCliente" value="{{ $numero_remito_cliente }}">


                <x-form-input-default>
                    <x-slot name="label">Item Nro</x-slot>
                    <x-slot name="name">ItemNumero</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('ItemNumero', $count_items)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('ItemNumero'))
                            {{ $errors->first('ItemNumero') }}
                        @elseif (old('ItemNumero'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('ItemNumero'))
                            is-invalid
                        @elseif (old('ItemNumero') && ! $errors->has('ItemNumero'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>
                            
                <x-form-input-default>
                    <x-slot name="label">Cantidad</x-slot>
                    <x-slot name="name">Cantidad</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Cantidad', "1.00")}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Cantidad'))
                            {{ $errors->first('Cantidad') }}
                        @elseif (old('Cantidad'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                      @if ($errors->has('Cantidad'))
                          is-invalid
                      @elseif(old('Cantidad') !== null && ! $errors->has('Cantidad'))
                          is-valid
                      @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-select>
                    <x-slot name="label">Dureza</x-slot>
                    <x-slot name="name">IdDureza</x-slot>
                    <x-slot name="option">
                      @foreach ($durezas as $dureza)
                        <option value="{{$dureza->id}}">{{$dureza->Nombre}}</option>
                      @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('IdDureza'))
                            {{ $errors->first('IdDureza') }}
                        @elseif (old('IdDureza'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdDureza'))
                            is-invalid
                        @elseif (old('IdDureza') && ! $errors->has('IdDureza'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>

                <x-form-input-select>
                    <x-slot name="label">Material</x-slot>
                    <x-slot name="name">IdMaterial</x-slot>
                    <x-slot name="option">
                      @foreach ($materiales as $material)
                        <option value="{{$material->id}}">{{$material->Nombre}}</option>
                      @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('IdMaterial'))
                            {{ $errors->first('IdMaterial') }}
                        @elseif (old('IdMaterial'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdMaterial'))
                            is-invalid
                        @elseif (old('IdMaterial') && ! $errors->has('IdMaterial'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>
            </div>

            <div class="col-md-4 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Descripción</x-slot>
                    <x-slot name="name">Descripcion</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Descripcion')}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Descripcion'))
                            {{ $errors->first('Descripcion') }}
                        @elseif (old('Descripcion'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Descripcion'))
                            is-invalid
                        @elseif (old('Descripcion') && ! $errors->has('Descripcion'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-default>
                    <x-slot name="label">Peso</x-slot>
                    <x-slot name="name">Peso</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Peso', "0.00")}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Peso'))
                            {{ $errors->first('Peso') }}
                        @elseif (old('Peso'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Peso'))
                            is-invalid
                        @elseif (old('Peso') && ! $errors->has('Peso'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-default>
                    <x-slot name="label">DSMIN</x-slot>
                    <x-slot name="name">DurezaSolicitadaMinima</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('DurezaSolicitadaMinima', 0)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('DurezaSolicitadaMinima'))
                            {{ $errors->first('DurezaSolicitadaMinima') }}
                        @elseif (session()->has('_old_input') && old('DurezaSolicitadaMinima') !== null && ! $errors->has('DurezaSolicitadaMinima'))
                            Todo correcto
                        @endif
                    </x-slot>

                    <x-slot name="error">
                        @if ($errors->has('DurezaSolicitadaMinima'))
                            is-invalid
                        @elseif (session()->has('_old_input') && old('DurezaSolicitadaMinima') !== null && ! $errors->has('DurezaSolicitadaMinima'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-select>
                    <x-slot name="label">CC</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="option">
                    </x-slot>
                    <x-slot name="message">
                        Todo correcto
                    </x-slot>
                    <x-slot name="error">
                        is-valid
                    </x-slot>
                </x-form-input-select>
            </div>

            <div class="col-md-4 mb-3">
              <x-form-input-default>
                  <x-slot name="label">Nro Plano</x-slot>
                  <x-slot name="name"></x-slot>
                  <x-slot name="placeholder"></x-slot>
                  <x-slot name="value"></x-slot>
                    <x-slot name="message">
                        Todo correcto
                    </x-slot>
                    <x-slot name="error">
                        is-valid
                    </x-slot>
              </x-form-input-default>

              <x-form-input-select>
                <x-slot name="label">Tratamiento</x-slot>
                <x-slot name="name">IdTratamiento</x-slot>
                <x-slot name="option">
                  @foreach ($tratamientos as $tratamiento)
                    <option value="{{$tratamiento->id}}">{{$tratamiento->Nombre}}</option>
                  @endforeach
                </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('IdTratamiento'))
                            {{ $errors->first('IdTratamiento') }}
                        @elseif (old('IdTratamiento'))
                            Todo correcto
                        @endif
                    </x-slot>
                <x-slot name="error">
                    @if ($errors->has('IdTratamiento'))
                        is-invalid
                    @elseif (old('IdTratamiento') && ! $errors->has('IdTratamiento'))
                        is-valid
                    @endif
                </x-slot>
              </x-form-input-select>
                          
              <x-form-input-default>
                  <x-slot name="label">DSMAX</x-slot>
                  <x-slot name="name">DurezaSolicitadaMaxima</x-slot>
                  <x-slot name="placeholder"></x-slot>
                  <x-slot name="value">{{old('DurezaSolicitadaMaxima', 0)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('DurezaSolicitadaMaxima'))
                            {{ $errors->first('DurezaSolicitadaMaxima') }}
                        @elseif (session()->has('_old_input') && old('DurezaSolicitadaMaxima') !== null && ! $errors->has('DurezaSolicitadaMaxima'))
                            Todo correcto
                        @endif
                    </x-slot>

                    <x-slot name="error">
                        @if ($errors->has('DurezaSolicitadaMaxima'))
                            is-invalid
                        @elseif (session()->has('_old_input') && old('DurezaSolicitadaMaxima') !== null && ! $errors->has('DurezaSolicitadaMaxima'))
                            is-valid
                        @endif
                    </x-slot>
              </x-form-input-default>

              <x-form-input-select>
                  <x-slot name="label">Estado</x-slot>
                  <x-slot name="name">Estado</x-slot>
                  <x-slot name="option">
                      <option value="PENDIENTE">Pendiente</option>
                      <option value="APROBADO">Aprobado</option>
                      <option value="NO APTO">No Apto</option>
                  </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Estado'))
                            {{ $errors->first('Estado') }}
                        @elseif (old('Estado'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('Estado'))
                          is-invalid
                      @elseif (old('Estado') && ! $errors->has('Estado'))
                          is-valid
                      @endif
                  </x-slot>
              </x-form-input-select>
            </div>
        </x-slot>
        <x-slot name="buttons">
            <x-form-button>
                <x-slot name="text">Aceptar</x-slot>
                <x-slot name="color">success</x-slot>
            </x-form-button>
            <x-button-js>
                <x-slot name="text">Volver</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('orden-trabajo.edit', $orden_trabajo) }}</x-slot>
                <x-slot name="js">onclick="redirigirAVolverConInputs()"</x-slot>
            </x-button-js>
        </x-slot>
    </x-form>

    <script>
        function redirigirAVolverConInputs() {
            const ordenTrabajoId = @json($orden_trabajo->id);

            const puntoVenta = document.querySelector('[name="PuntoVenta"]').value;
            const idCliente = document.querySelector('[name="IdCliente"]').value;
            const numero = document.querySelector('[name="Numero"]').value;
            const fechaEmision = document.querySelector('[name="FechaEmision"]').value;
            const numeroRemitoCliente = document.querySelector('[name="NumeroRemitoCliente"]').value;

            const url = new URL(`{{ url('/orden-trabajo') }}/${ordenTrabajoId}/edit`);
            url.searchParams.append('PuntoVenta', puntoVenta);
            url.searchParams.append('IdCliente', idCliente);
            url.searchParams.append('Numero', numero);
            url.searchParams.append('FechaEmision', fechaEmision);
            url.searchParams.append('NumeroRemitoCliente', numeroRemitoCliente);

            window.location.href = url.toString();
        }
    </script>


</x-layout>