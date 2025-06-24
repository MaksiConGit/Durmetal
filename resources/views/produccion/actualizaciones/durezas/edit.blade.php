<x-layout>

  <x-slot name="title">Produccion</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Durezas</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Editar durezas</a></li>
  </x-slot>

    <x-form>
        <x-slot name="card_title">Editar dureza</x-slot>
        <x-slot name="action">{{ route('durezas.update', $dureza) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">Nombre</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Nombre', $dureza->Nombre)}}</x-slot>
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

                <input type="hidden" name="Predeterminado" value="0">
                <x-form-input-checkbox>
                    <x-slot name="label">Predeterminado</x-slot>
                    <x-slot name="name">Predeterminado</x-slot>
                    <x-slot name="value">1</x-slot>
                    <x-slot name="color">black</x-slot>
                    <x-slot name="checked">{{ $dureza->Predeterminado == 1 ? 'checked' : '' }}</x-slot>
                </x-form-input-checkbox>
            </div>

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Descripcion</x-slot>
                    <x-slot name="name">Descripcion</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Descripcion', $dureza->Descripcion)}}</x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Descripcion'))
                            {{ $errors->first('Descripcion') }}
                        @elseif (old('Descripcion'))
                            Todo correcto
                        @endif
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
                    <x-slot name="href">{{ route('durezas.index') }}</x-slot>
                </x-button>
            </div>
        </x-slot>
    </x-form>
</x-layout>