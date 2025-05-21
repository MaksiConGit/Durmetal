<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ingreso de materiales</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Selección de Orden de Trabajo</a></li>
    </x-slot>

    <x-form>
        <x-slot name="title">Durmetal</x-slot>
        <x-slot name="card_title">Ingreso de materiales</x-slot>
        <x-slot name="action">{{ route('orden-trabajo.store') }}</x-slot>
        <x-slot name="method"></x-slot>

        <x-slot name="inputs">

            <div class="col-md-6 mb-3">
            
                <x-form-input-select>
                    <x-slot name="label">Punto de Venta</x-slot>
                    <x-slot name="name">pto_venta_id</x-slot>
                    <x-slot name="option">
                        @foreach ($pto_ventas as $pto_venta)
                            <option value="{{$pto_venta->id}}">{{$pto_venta->Nombre}}</option>                            
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @error('pto_venta_id')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('pto_venta_id'))
                            is-invalid
                        @elseif (old('pto_venta_id') && ! $errors->has('pto_venta_id'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>

            </div>

            <div class="col-md-6 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Número</x-slot>
                    <x-slot name="name">Numero</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Numero', $next_orden_numero)}}</x-slot>
                    <x-slot name="message">
                        @error('Numero')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Numero'))
                            is-invalid
                        @elseif (old('Numero') && ! $errors->has('Numero'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-default>

            </div>

        </x-slot>
        <x-slot name="buttons">
            <x-form-button>
                <x-slot name="text">Aceptar</x-slot>
                <x-slot name="color">success</x-slot>
            </x-form-button>
            <x-button>
                <x-slot name="text">Cancelar</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>

</x-layout>