<x-layout>
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-dollar-sign"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Divisas</a></li>
    </x-slot>

    <x-form>
        <x-slot name="card_title">Divisas</x-slot>
        <x-slot name="action">{{ route('divisas.update', $configuracion_global) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-6 mb-3">
            
                <x-form-input-default>
                    <x-slot name="label">USD -> ARS</x-slot>
                    <x-slot name="name">USD_ARS</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('USD_ARS', number_format($configuracion_global->USD_ARS, 2, '.', '') )}}</x-slot>
                    <x-slot name="message">
                        @error('USD_ARS')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('USD_ARS'))
                            is-invalid
                        @elseif (old('USD_ARS') && ! $errors->has('USD_ARS'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

            </div>

            <div class="col-md-6 mb-3">

                <x-form-input-date-disabled>
                    <x-slot name="label">Fecha de Actualización</x-slot>
                    <x-slot name="name">FechaActualizacionUSD_ARS</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('FechaActualizacionUSD_ARS', $configuracion_global->FechaActualizacionUSD_ARS)}}</x-slot>
                    <x-slot name="message">
                        @error('FechaActualizacionUSD_ARS')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('FechaActualizacionUSD_ARS'))
                            is-invalid
                        @elseif (old('FechaActualizacionUSD_ARS') && ! $errors->has('FechaActualizacionUSD_ARS'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-date-disabled>

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
                    <x-slot name="href">{{ route('index') }}</x-slot>
                </x-button>
            </div>

        </x-slot>
    </x-form>

</x-layout>