<x-layout2>
    <x-slot name="title">cliente: "{{ $client->Nombre }}"</x-slot>

    <form action="{{ route('clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')

        @livewire('codigo-postal-localidad-provincia-edit', [
            'client' => $client,
            'condiciones_IVA' => $iva_conditions,
            'calificaciones_cliente' => $client_qualifications,
        ])

        <div class="row">
            <div class="col-2"></div>
            <div class="card col-8">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-4 mb-3">
                            <div class="form-group mb-0">
                                <label for="" class="font-weight-normal">EMAILS</label>
                                <input type="text" id="email1" name="emails[]" value="{{ $oldEmails[0] ?? '' }}"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-4 mb-3 mt-2">
                            <div class="form-group mb-0">
                                <label for="email2" class="font-weight-normal"></label>
                                <input type="text" id="email2" name="emails[]" value="{{ $oldEmails[1] ?? '' }}"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-4 mb-3 mt-2">
                            <div class="form-group mb-0">
                                <label for="email2" class="font-weight-normal"></label>
                                <input type="text" id="email2" name="emails[]" value="{{ $oldEmails[2] ?? '' }}"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-4 mb-3">
                            <div class="form-group mb-0">
                                <label for="email3" class="font-weight-normal"></label>
                                <input type="text" id="email3" name="emails[]" value="{{ $oldEmails[3] ?? '' }}"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="form-group mb-0">
                                <label for="email4" class="font-weight-normal"></label>
                                <input type="text" id="email4" name="emails[]" value="{{ $oldEmails[4] ?? '' }}"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="form-group mb-0">
                                <label for="email4" class="font-weight-normal"></label>
                                <input type="text" id="email4" name="emails[]" value="{{ $oldEmails[5] ?? '' }}"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-4 mb-3">
                            <div class="form-group mb-0">
                                <label for="email5" class="font-weight-normal"></label>
                                <input type="text" id="email5" name="emails[]" value="{{ $oldEmails[6] ?? '' }}"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="form-group mb-0">
                                <label for="email6" class="font-weight-normal"></label>
                                <input type="text" id="email6" name="emails[]" value="{{ $oldEmails[7] ?? '' }}"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="form-group mb-0">
                                <label for="email6" class="font-weight-normal"></label>
                                <input type="text" id="email6" name="emails[]" value="{{ $oldEmails[8] ?? '' }}"
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

{{-- 
<x-layout>

    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
          </li>
          <li class="separator"><i class="icon-arrow-right"></i></li>
          <li class="nav-item"><a href="#">Clientes</a></li>
          <li class="separator"><i class="icon-arrow-right"></i></li>
          <li class="nav-item"><a href="#">Editar cliente</a></li>
    </x-slot>

    <x-form>

        <x-slot name="card_title">Añadir cliente</x-slot>
        <x-slot name="action">{{ route('clients.update', $client) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Código</x-slot>
                    <x-slot name="name">id</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('id', $client->id)}}</x-slot>
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
                </x-form-input-default>
                            
                <x-form-input-default>
                    <x-slot name="label">Domicilio</x-slot>
                    <x-slot name="name">Domicilio</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Domicilio', $client->Domicilio)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Domicilio'))
                            {{ $errors->first('Domicilio') }}
                        @elseif (old('Domicilio'))
                            Todo correcto
                        @endif
                    </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('Domicilio'))
                          is-invalid
                      @elseif (old('Domicilio') && ! $errors->has('Domicilio'))
                          is-valid
                      @endif
                  </x-slot>
                </x-form-input-default>

                @livewire('localidad-edit', ['initialCityId' => $client->IdLocalidad])

                <x-form-input-default>
                    <x-slot name="label">Teléfono</x-slot>
                    <x-slot name="name">Telefono</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Telefono', $client->Telefono)}}</x-slot>
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

                <x-form-input-select>
                    <x-slot name="label">Tipo de Documento</x-slot>
                    <x-slot name="name">TipoDocumento</x-slot>
                    <x-slot name="option">
                            <option value="CUIT">CUIT</option>
                            <option value="CUIL" {{$client->TipoDocumento == 'CUIL' ? 'selected' : ''}}>CUIL</option>
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('TipoDocumento'))
                            {{ $errors->first('TipoDocumento') }}
                        @elseif (old('TipoDocumento'))
                            Todo correcto
                        @endif
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
                        @foreach ($client_qualifications as $client_qualification)
                            <option value="{{ $client_qualification->id }}" {{$client_qualification->id == $client->calificacionCliente->id ? 'selected' : ''}}>
                                {{ $client_qualification->Nombre }}
                            </option>
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('IdCalificacionCliente'))
                            {{ $errors->first('IdCalificacionCliente') }}
                        @elseif (old('IdCalificacionCliente'))
                            Todo correcto
                        @endif
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
                    <x-slot name="checked">{{ old('Activo', $client->Activo) ? 'checked' : '' }}</x-slot>
                </x-form-input-checkbox>
            </div>

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">Nombre</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Nombre', $client->Nombre)}}</x-slot>
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

                @livewire('codigo-postal-provincia-edit', ['initialCityId' => $client->IdLocalidad])

                <x-form-input-select>
                    <x-slot name="label">Condición IVA</x-slot>
                    <x-slot name="name">IdCondicionIVA</x-slot>
                    <x-slot name="option">
                        @foreach ($iva_conditions as $iva_condition)
                            <option value="{{ $iva_condition->id }}" {{$iva_condition->id == $client->condicionIVA->id ? 'selected' : ''}}>
                                {{ $iva_condition->Nombre }}
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
                    <x-slot name="label">N° de Documento</x-slot>
                    <x-slot name="name">NroDocumento</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('NroDocumento', $client->NroDocumento)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('NroDocumento'))
                            {{ $errors->first('NroDocumento') }}
                        @elseif (old('NroDocumento'))
                            Todo correcto
                        @endif
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
                    <x-slot name="value">{{old('Saldo', $client->Saldo)}}</x-slot>
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

            </div>


            <div class="col-md-6 mb-3">
            @for ($i = 0; $i < 3; $i++)
                <x-form-input-email>
                    <x-slot name="label">{{ $i == 0 ? 'Email' : '' }}</x-slot>
                    <x-slot name="name">emails[]</x-slot>
                    <x-slot name="placeholder">cliente@cliente.com</x-slot>
                    <x-slot name="value">{{ $oldEmails[$i] ?? '' }}</x-slot>
                </x-form-input-email>
            @endfor
            </div>

            <div class="col-md-6 mb-3">
            @for ($i = 3; $i < 6; $i++)
                <x-form-input-email>
                    <x-slot name="label">{{ $i == 3 ? '-' : '' }}</x-slot>
                    <x-slot name="name">emails[]</x-slot>
                    <x-slot name="placeholder">cliente@cliente.com</x-slot>
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
                <x-slot name="href">{{ route('clients.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>
</x-layout> --}}

