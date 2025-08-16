<x-layout>
    <x-slot name="title">Otros Egresos</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Cuentas</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Añadir Cuenta</a></li>
    </x-slot>

    <x-form>
        <x-slot name="title">Durmetal</x-slot>
        <x-slot name="card_title">Crear Cuenta</x-slot>
        <x-slot name="action">{{ route('otros-egresos.actualizaciones.cuentas.store') }}</x-slot>
        <x-slot name="method"></x-slot>

        <x-slot name="inputs">

            <div class="col-md-8 mb-3">
            
                <x-form-input-select>
                    <x-slot name="label">Cuenta Padre</x-slot>
                    <x-slot name="name">IdCuentaOtrosEgresosPadre</x-slot>
                    <x-slot name="option">
                        <option value="">No tiene</option>
                        @foreach ($cuentas_otros_egresos_padre as $padre)
                            <option value="{{ $padre->id }}"
                                {{ old('IdCuentaOtrosEgresosPadre') == $padre->id ? 'selected' : '' }}>
                                {{ $padre->Nombre }}
                            </option>
                        @endforeach
                    </x-slot>
                    <x-slot name="message">
                        @error('IdCuentaOtrosEgresosPadre')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('IdCuentaOtrosEgresosPadre'))
                            is-invalid
                        @elseif (old('IdCuentaOtrosEgresosPadre') && ! $errors->has('IdCuentaOtrosEgresosPadre'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>

            </div>

            <div class="col-md-8 mb-3">

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

            </div>

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Descripcion</x-slot>
                    <x-slot name="name">Descripcion</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Descripcion')}}</x-slot>
                    <x-slot name="message">
                        @error('Descripcion')
                            {{$message}}
                        @enderror
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Descripcion'))
                            is-invalid
                        @elseif (old('Descripcion') && ! $errors->has('Descripcion'))
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
                    <x-slot name="href">{{ route('otros-egresos.actualizaciones.cuentas.index') }}</x-slot>
                </x-button>
            </div>

        </x-slot>
    </x-form>

</x-layout>