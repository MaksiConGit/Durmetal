<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Repartir Premios</a></li>
    </x-slot>
    <x-form>
        <x-slot name="card_title">Repartir premios por producción</x-slot>
        <x-slot name="action">{{ route('repartir-premios.store') }}</x-slot>
        <x-slot name="method"></x-slot>
        <x-slot name="inputs">

        <div class="row mb-3 align-items-center">

            <div class="col-md-3">

                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">Nombre</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Nombre')}}</x-slot>
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

            </div>

            <div class="col-md-3">

                <x-form-input-date>
                    <x-slot name="label">Desde</x-slot>
                    <x-slot name="name">FechaDesde</x-slot>
                    <x-slot name="value">
                        {{ old('FechaDesde', session('FechaDesde', \Carbon\Carbon::now()->startOfMonth()->toDateString())) }}
                    </x-slot>               
                    <x-slot name="message">
                        @if ($errors->has('FechaDesde'))
                            {{ $errors->first('FechaDesde') }}
                        @elseif (old('FechaDesde'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('FechaDesde'))
                            is-invalid
                        @elseif (old('FechaDesde') && ! $errors->has('FechaDesde'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-date>

            </div>

            <div class="col-md-3">

                <x-form-input-date>
                    <x-slot name="label">Hasta</x-slot>
                    <x-slot name="name">FechaHasta</x-slot>
                    <x-slot name="value">
                        {{ old('FechaHasta', session('FechaHasta', \Carbon\Carbon::now()->endOfMonth()->toDateString())) }}
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('FechaHasta'))
                            {{ $errors->first('FechaHasta') }}
                        @elseif (old('FechaHasta'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('FechaHasta'))
                            is-invalid
                        @elseif (old('FechaHasta') && ! $errors->has('FechaHasta'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-date>

            </div>

            <div class="col-md-3">
                <x-form-input-select>
                    <x-slot name="label">Estado</x-slot>
                    <x-slot name="name">Estado</x-slot>
                    <x-slot name="option">
                        <option value="PENDIENTE">PENDIENTE</option>
                        <option value="COMPLETO">COMPLETO</option>
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Estado'))
                            {{ $errors->first('Estado') }}
                        @elseif (old('Estado'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Estado'))
                            is-invalid
                        @elseif (old('Estado') && ! $errors->has('Estado'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>
            </div>

        </div>

        @livewire('repartir-premios-form', ['empleados' => $empleados])

    </x-slot>
    <x-slot name="buttons">
        <x-form-button>
            <x-slot name="text">Guardar</x-slot>
            <x-slot name="color">success</x-slot>
        </x-form-button>
        <x-button>
            <x-slot name="text">Cancelar</x-slot>
            <x-slot name="color">danger</x-slot>
            <x-slot name="href">{{ route('index') }}</x-slot>
        </x-button>
    </x-slot>

    <x-slot name="buttons">

        <div class="row">
            <div class="col text-end">
                <x-form-button>
                    <x-slot name="text">Guardar</x-slot>
                    <x-slot name="color">success</x-slot>
                </x-form-button>
                <x-button>
                    <x-slot name="text">Cancelar</x-slot>
                    <x-slot name="color">danger</x-slot>
                    <x-slot name="href">{{ route('repartir-premios.index') }}</x-slot>
                </x-button>
            </div>
        </div>

    </x-slot>


  </x-form>

</x-layout>