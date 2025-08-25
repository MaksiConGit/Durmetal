<x-layout>
    <x-slot name="title">Sistema</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-sliders-h"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Configuración</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Terminales</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Añadir Terminal</a></li>
    </x-slot>

    <x-form>
        <x-slot name="title">Durmetal</x-slot>
        <x-slot name="card_title">Añadir Terminal</x-slot>
        <x-slot name="action">{{ route('sistema.configuracion.terminales.update', $terminal) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Nombre de Host</x-slot>
                    <x-slot name="name">NombreHost</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('NombreHost', $terminal->NombreHost)}}</x-slot>
                    <x-slot name="message">
                        @error('NombreHost')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('NombreHost'))
                            is-invalid
                        @elseif (old('NombreHost') && ! $errors->has('NombreHost'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

            </div>

            <div class="col-md-8 mb-3">
                <x-form-input-select>
                    <x-slot name="label">Impresora Fiscal</x-slot>
                    <x-slot name="name">IdImpresoraFiscal</x-slot>
                    <x-slot name="option">
                    @foreach ($impresoras_fiscales as $impresora_fiscal)
                        <option value="{{$impresora_fiscal->id}}" {{ $terminal->IdImpresoraFiscal == $impresora_fiscal->id ? 'selected' : '' }}>{{$impresora_fiscal->Nombre}}</option>                            
                    @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('IdImpresoraFiscal'))
                            {{ $errors->first('IdImpresoraFiscal') }}
                        @elseif (old('IdImpresoraFiscal'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdImpresoraFiscal'))
                            is-invalid
                        @elseif (old('IdImpresoraFiscal') && ! $errors->has('IdImpresoraFiscal'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>
            </div>

            <div class="col-md-8 mb-3">
                <x-form-input-select>
                    <x-slot name="label">Etiquetadora</x-slot>
                    <x-slot name="name">NombreEtiquetadora</x-slot>
                    <x-slot name="option">
                        <option value="-1" {{ $terminal->NombreEtiquetadora == '-1' ? 'selected' : '' }}>No hay etiquetadora asociada</option>
                        <option value="Microsoft XPS Document Writer">Microsoft XPS Document Writer</option>
                        <option value="Fax">Fax</option>
                        <option value="Brother QL-800">Brother QL-800</option>
                        <option value="Brother DCP-J140W Printer">Brother DCP-J140W Printer</option>
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('NombreEtiquetadora'))
                            {{ $errors->first('NombreEtiquetadora') }}
                        @elseif (old('NombreEtiquetadora'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('NombreEtiquetadora'))
                            is-invalid
                        @elseif (old('NombreEtiquetadora') && ! $errors->has('NombreEtiquetadora'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>
            </div>

        </x-slot>
        <x-slot name="buttons">

            <div class="d-flex justify-content-end gap-2">
                <x-form-button>
                    <x-slot name="text">Guardar</x-slot>
                    <x-slot name="color">success</x-slot>
                </x-form-button>
                <x-button>
                    <x-slot name="text">Cancelar</x-slot>
                    <x-slot name="color">danger</x-slot>
                    <x-slot name="href">{{ route('sistema.configuracion.terminales.index') }}</x-slot>
                </x-button>
            </div>

        </x-slot>
    </x-form>

</x-layout>