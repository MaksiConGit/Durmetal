<x-layout>
    <x-slot name="title">Sistema</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-sliders-h"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Impresoras Fiscales</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Editar Impresora Fiscal</a></li>
    </x-slot>

    <x-form>
        <x-slot name="title">Durmetal</x-slot>
        <x-slot name="card_title">Editar Impresora Fiscal</x-slot>
        <x-slot name="action">{{ route('sistema.configuracion.impresoras-fiscales.update', $impresora_fiscal) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">Nombre</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Nombre', $impresora_fiscal->Nombre)}}</x-slot>
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

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Modelo</x-slot>
                    <x-slot name="name">Modelo</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Modelo', $impresora_fiscal->Modelo)}}</x-slot>
                    <x-slot name="message">
                        @error('Modelo')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Modelo'))
                            is-invalid
                        @elseif (old('Modelo') && ! $errors->has('Modelo'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Número de puerto COM</x-slot>
                    <x-slot name="name">PuertoCOM</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('PuertoCOM', $impresora_fiscal->PuertoCOM)}}</x-slot>
                    <x-slot name="message">
                        @error('PuertoCOM')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('PuertoCOM'))
                            is-invalid
                        @elseif (old('PuertoCOM') && ! $errors->has('PuertoCOM'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Velocidad del puerto</x-slot>
                    <x-slot name="name">VelocidadPrEpson</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('VelocidadPrEpson', $impresora_fiscal->VelocidadPrEpson)}}</x-slot>
                    <x-slot name="message">
                        @error('VelocidadPrEpson')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('VelocidadPrEpson'))
                            is-invalid
                        @elseif (old('VelocidadPrEpson') && ! $errors->has('VelocidadPrEpson'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Tipo de protocolo impresoras Epson</x-slot>
                    <x-slot name="name">TipoProtocoloPrEpson</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('TipoProtocoloPrEpson', $impresora_fiscal->TipoProtocoloPrEpson)}}</x-slot>
                    <x-slot name="message">
                        @error('TipoProtocoloPrEpson')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('TipoProtocoloPrEpson'))
                            is-invalid
                        @elseif (old('TipoProtocoloPrEpson') && ! $errors->has('TipoProtocoloPrEpson'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

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
                    <x-slot name="href">{{ route('sistema.configuracion.impresoras-fiscales.index') }}</x-slot>
                </x-button>
            </div>

        </x-slot>
    </x-form>

</x-layout>