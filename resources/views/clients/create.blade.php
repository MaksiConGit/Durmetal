<x-layout>
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
                </x-form-input-default>
                            
                <x-form-input-default>
                    <x-slot name="label">Domicilio</x-slot>
                    <x-slot name="name">address</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('address')}}</x-slot>
                </x-form-input-default>

                @livewire('localidad')

                <x-form-input-default>
                    <x-slot name="label">Teléfono</x-slot>
                    <x-slot name="name">phone</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('phone')}}</x-slot>
                </x-form-input-default>

                <x-form-input-select>
                    <x-slot name="label">Tipo de Documento</x-slot>
                    <x-slot name="name">document_type_id</x-slot>
                    <x-slot name="option">
                        @foreach ($document_types as $document_type)
                            <option value="{{ $document_type->id }}" {{$document_type->id == '1' ? 'selected' : ''}}>
                                {{ $document_type->name }}
                            </option>
                        @endforeach
                    </x-slot>
                </x-form-input-select>

                <x-form-input-select>
                    <x-slot name="label">Calificación</x-slot>
                    <x-slot name="name">client_qualification_id</x-slot>
                    <x-slot name="option">
                        @foreach ($client_qualifications as $client_qualification)
                            <option value="{{ $client_qualification->id }}" {{$client_qualification->id == '1' ? 'selected' : ''}}>
                                {{ $client_qualification->name }}
                            </option>
                        @endforeach
                    </x-slot>
                </x-form-input-select>

                <input type="hidden" name="is_active" value="0">
                <x-form-input-checkbox>
                    <x-slot name="label">Activo</x-slot>
                    <x-slot name="name">is_active</x-slot>
                    <x-slot name="value">1</x-slot>
                    <x-slot name="color">black</x-slot>
                    <x-slot name="checked">checked</x-slot>
                </x-form-input-checkbox>
            </div>

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">name</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('name')}}</x-slot>
                </x-form-input-default>

                @livewire('codigo-postal-provincia')

                <x-form-input-select>
                    <x-slot name="label">Condición IVA</x-slot>
                    <x-slot name="name">iva_condition_id</x-slot>
                    <x-slot name="option">
                        @foreach ($iva_conditions as $iva_condition)
                            <option value="{{ $iva_condition->id }}" {{$iva_condition->id == '1' ? 'selected' : ''}}>
                                {{ $iva_condition->name }}
                            </option>
                        @endforeach
                    </x-slot>
                </x-form-input-select>
                
                <x-form-input-default>
                    <x-slot name="label">N° de Documento</x-slot>
                    <x-slot name="name">document_number</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('document_number')}}</x-slot>
                </x-form-input-default>
    
                <x-form-input-default>
                    <x-slot name="label">Saldo Transportado</x-slot>
                    <x-slot name="name">balance</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('balance')}}</x-slot>
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
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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