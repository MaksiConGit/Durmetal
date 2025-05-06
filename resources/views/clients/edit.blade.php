
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
                    <x-slot name="value">{{old('Domicilio', $client->Domicilio)}}</x-slot>
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

                @livewire('localidad-edit', ['initialCityId' => $client->IdLocalidad])

                <x-form-input-default>
                    <x-slot name="label">Teléfono</x-slot>
                    <x-slot name="name">Telefono</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Telefono', $client->Telefono)}}</x-slot>
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
                            <option value="CUIL" {{$client->TipoDocumento == 'CUIL' ? 'selected' : ''}}>CUIL</option>
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
                        @foreach ($client_qualifications as $client_qualification)
                            <option value="{{ $client_qualification->id }}" {{$client_qualification->id == $client->calificacionCliente->id ? 'selected' : ''}}>
                                {{ $client_qualification->Nombre }}
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
                        @error('IdCondiciónIVA')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdCondiciónIVA'))
                            is-invalid
                        @elseif (old('IdCondiciónIVA') && ! $errors->has('IdCondiciónIVA'))
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
                    <x-slot name="value">{{old('Saldo', $client->Saldo)}}</x-slot>
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
</x-layout>

{{-- <x-layout>

    <div>
        <h2>Añadir cliente</h2>
    
        <form action="{{ route('clients.update', $client) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="id">Código</label>
                <input type="text" name="id" id="id" required value="{{old('id', $client->id)}}">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" required value="{{old('name', $client->name)}}">
            </div>
            <br>
            <div>
                @livewire('client-location-edit', ['client' => $client])
            </div>
            <br>
            <div>
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" id="phone" required value="{{old('phone', $client->phone)}}">
                <label for="iva_condition_id">Condición IVA</label>
                <select name="iva_condition_id" id="iva_condition_id">
                    @foreach ($iva_conditions as $iva_condition)
                        <option value="{{ $iva_condition->id }}" {{$iva_condition->id == $client->ivaCondition->id ? 'selected' : ''}}>
                            {{ $iva_condition->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <br>
            <div>
                <label for="document_type_id">Tipo de Documento</label>
                <select name="document_type_id" id="document_type_id">
                    @foreach ($document_types as $document_type)
                        <option value="{{ $document_type->id }}" {{$document_type->id == $client->documentType->id ? 'selected' : ''}}>
                            {{ $document_type->name }}
                        </option>
                    @endforeach
                </select>
                <label for="document_number">N° de Documento</label>
                <input type="text" name="document_number" id="document_number" required value="{{old('document_number', $client->document_number)}}">
            </div>
            <br>
            <div>
                <label for="client_qualification_id">Calificación</label>
                <select name="client_qualification_id" id="client_qualification_id">
                    @foreach ($client_qualifications as $client_qualification)
                        <option value="{{ $client_qualification->id }}" {{$client_qualification->id == $client->documentType->id ? 'selected' : ''}}>
                            {{ $client_qualification->name }}
                        </option>
                    @endforeach
                </select>
                <label for="balance">Saldo Transportado</label>
                <input type="text" name="balance" id="balance" required value="{{old('balance', $client->balance)}}">
            </div>
            <div>
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $client->is_active) ? 'checked' : '' }}>
                <label for="is_active">Activo</label>
            </div>            
            <br>
    
            <label for="emails">Emails</label>
            <div>
                @php
                    $oldEmails = old('emails', $client_emails->pluck('text')->toArray());
                @endphp
        
                @for ($i = 0; $i < 6; $i++)
                    <input type="email" name="emails[]" value="{{ $oldEmails[$i] ?? '' }}">
                    <br><br>
                @endfor
            </div>        
    
    
            <br>
            <button type="submit">Guardar</button>
            <a href="{{ route('clients.index') }}">Volver</a>
        </form> 
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
    </div>
</x-layout> --}}


