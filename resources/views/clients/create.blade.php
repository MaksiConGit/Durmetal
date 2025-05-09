<x-layout>

    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
          </li>
          <li class="separator"><i class="icon-arrow-right"></i></li>
          <li class="nav-item"><a href="#">Clientes</a></li>
          <li class="separator"><i class="icon-arrow-right"></i></li>
          <li class="nav-item"><a href="#">Añadir clientes</a></li>
    </x-slot>

    <x-form>
        <x-slot name="title">Durmetal</x-slot>
        <x-slot name="breadcrumbs">
            <li class="nav-home">
                <a href="#"><i class="icon-home"></i></a>
              </li>
              <li class="separator"><i class="icon-arrow-right"></i></li>
              <li class="nav-item"><a href="#">Clientes</a></li>
              <li class="separator"><i class="icon-arrow-right"></i></li>
              <li class="nav-item"><a href="#">Añadir clientes</a></li>
        </x-slot>
        <x-slot name="card_title">Añadir cliente</x-slot>
        <x-slot name="action">{{ route('clients.store') }}</x-slot>
        <x-slot name="method"></x-slot>

        <x-slot name="inputs">

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Código</x-slot>
                    <x-slot name="name">id</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('id', $next_id)}}</x-slot>
                    <x-slot name="message">
                        @error('id')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('id'))
                            is-invalid
                        @elseif (old('id') && ! $errors->has('id'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>
                            
                <x-form-input-default>
                    <x-slot name="label">Domicilio</x-slot>
                    <x-slot name="name">Domicilio</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Domicilio')}}</x-slot>
                    <x-slot name="message">
                        @error('Domicilio')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Domicilio'))
                            is-invalid
                        @elseif (old('Domicilio') && ! $errors->has('Domicilio'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                @livewire('localidad')

                <x-form-input-default>
                    <x-slot name="label">Teléfono</x-slot>
                    <x-slot name="name">Telefono</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Telefono')}}</x-slot>
                    <x-slot name="message">
                        @error('Telefono')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Telefono'))
                            is-invalid
                        @elseif (old('Telefono') && ! $errors->has('Telefono'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                <x-form-input-select>
                    <x-slot name="label">Tipo de Documento</x-slot>
                    <x-slot name="name">TipoDocumento</x-slot>
                    <x-slot name="option">
                            <option value="CUIT">CUIT</option>
                            <option value="CUIL">CUIL</option>
                    </x-slot>
                    <x-slot name="message">
                        @error('TipoDocumento')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('TipoDocumento'))
                            is-invalid
                        @elseif (old('TipoDocumento') && ! $errors->has('TipoDocumento'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>

                <x-form-input-select>
                    <x-slot name="label">Calificación</x-slot>
                    <x-slot name="name">IdCalificacionCliente</x-slot>
                    <x-slot name="option">
                        @foreach ($calificaciones_cliente as $calificacion_cliente)
                            <option value="{{ $calificacion_cliente->id }}" {{$calificacion_cliente->id == '1' ? 'selected' : ''}}>
                                {{ $calificacion_cliente->Nombre }}
                            </option>
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @error('IdCalificacionCliente')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdCalificacionCliente'))
                            is-invalid
                        @elseif (old('IdCalificacionCliente') && ! $errors->has('IdCalificacionCliente'))
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
                    <x-slot name="checked">checked</x-slot>
                </x-form-input-checkbox>
            </div>

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">Nombre</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Nombre')}}</x-slot>
                    <x-slot name="message">
                        @error('Nombre')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Nombre'))
                            is-invalid
                        @elseif (old('Nombre') && ! $errors->has('Nombre'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

                @livewire('codigo-postal-provincia')

                <x-form-input-select>
                    <x-slot name="label">Condición IVA</x-slot>
                    <x-slot name="name">IdCondicionIVA</x-slot>
                    <x-slot name="option">
                        @foreach ($condiciones_IVA as $condicion_IVA)
                            <option value="{{ $condicion_IVA->id }}" {{$condicion_IVA->id == '1' ? 'selected' : ''}}>
                                {{ $condicion_IVA->Nombre }}
                            </option>
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @error('IdCondicionIVA')
                            {{$message}}
                        @enderror
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
                    <x-slot name="label">N° de Documento</x-slot>
                    <x-slot name="name">NroDocumento</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('NroDocumento')}}</x-slot>
                    <x-slot name="message">
                        @error('NroDocumento')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('NroDocumento'))
                            is-invalid
                        @elseif (old('NroDocumento') && ! $errors->has('NroDocumento'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>
    
                <x-form-input-default>
                    <x-slot name="label">Saldo Transportado</x-slot>
                    <x-slot name="name">Saldo</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Saldo')}}</x-slot>
                    <x-slot name="message">
                        @error('Saldo')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Saldo'))
                            is-invalid
                        @elseif (old('Saldo') && ! $errors->has('Saldo'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

            </div>

            {{-- Emails --}}
            <div class="col-md-6 mb-3">
                @for ($i = 0; $i < 3; $i++)
                    <x-form-input-email>
                        @if ($i <= 0)
                            <x-slot name="label">Email</x-slot>
                        @else
                            <x-slot name="label"></x-slot>
                        @endif
                        <x-slot name="name">emails[]</x-slot>
                        <x-slot name="placeholder">cliente@cliente.com</x-slot>
                        <x-slot name="value">{{ old('emails.' . $i) }}</x-slot>
                    </x-form-input-email>
                @endfor
            </div>
            <div class="col-md-6 mb-3">
                @for ($i = 3; $i < 6; $i++)
                    <x-form-input-email>
                        @if ($i <= 3)
                            <x-slot name="label">-</x-slot>
                        @else
                            <x-slot name="label"></x-slot>
                        @endif
                        <x-slot name="name">emails[]</x-slot>
                        <x-slot name="placeholder">cliente@cliente.com</x-slot>
                        <x-slot name="value">{{ old('emails.' . $i) }}</x-slot>
                    </x-form-input-email>
                @endfor
            </div>

        </x-slot>
        <x-slot name="buttons">
            <x-form-button>
                <x-slot name="text">Añadir</x-slot>
                <x-slot name="color">success</x-slot>
            </x-form-button>
            <x-button>
                <x-slot name="text">Volver</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('clients.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>
</x-layout>