<x-layout>
    <x-slot name="title">Sistema</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-sliders-h"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Tarjetas</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Añadir Banco</a></li>
    </x-slot>

    <x-form>
        <x-slot name="title">Durmetal</x-slot>
        <x-slot name="card_title">Editar Tarjeta</x-slot>
        <x-slot name="action">{{ route('sistema.actualizaciones.tarjetas.update', $tarjeta) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-8 mb-3">

                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">Nombre</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Nombre', $tarjeta->Nombre)}}</x-slot>
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

                <input type="hidden" name="Archivado" value="0">
                <x-form-input-checkbox>
                    <x-slot name="label">Archivado</x-slot>
                    <x-slot name="name">Archivado</x-slot>
                    <x-slot name="value">1</x-slot>
                    <x-slot name="color">black</x-slot>
                    <x-slot name="checked">
                        {{ old('Archivado', $tarjeta->Archivado) == 1 ? 'checked' : '' }}
                    </x-slot>
                </x-form-input-checkbox>

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
                    <x-slot name="href">{{ route('sistema.actualizaciones.tarjetas.index') }}</x-slot>
                </x-button>
            </div>

        </x-slot>
    </x-form>

</x-layout>