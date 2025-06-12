<x-layout>

  <x-slot name="title">Produccion</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Procesos</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Añadir procesos</a></li>
  </x-slot>

    <x-form>
        <x-slot name="card_title">Añadir proceso</x-slot>
        <x-slot name="action">{{ route('procesos.update', $proceso) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>

        <x-slot name="inputs">

            <div class="col-md-6 mb-3">
                <x-form-input-default>
                    <x-slot name="label">Nombre</x-slot>
                    <x-slot name="name">Nombre</x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value">{{old('Nombre', $proceso->Nombre)}}</x-slot>
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

                <input type="hidden" name="RequiereNumeracionSiempre" value="0">
                <x-form-input-checkbox>
                    <x-slot name="label">Requiere Numeración Siempre</x-slot>
                    <x-slot name="name">RequiereNumeracionSiempre</x-slot>
                    <x-slot name="value">1</x-slot>
                    <x-slot name="color">black</x-slot>
                    <x-slot name="checked">
                        {{ old('Predeterminado', $proceso->RequiereNumeracionSiempre) == 1 ? 'checked' : '' }}
                    </x-slot>
                </x-form-input-checkbox>
            </div>

            <div class="col-md-6 mb-3">
                <x-form-input-select>
                    <x-slot name="label">Tipo</x-slot>
                    <x-slot name="name">Tipo</x-slot>
                    <x-slot name="option">
                        <option value="PCO" {{"PCO" == old('Tipo') ? 'selected' : ''}} {{$proceso->Tipo == "PCO" ? 'selected' : ''}}>Convencional</option>
                        <option value="PNC" {{"PNC" == old('Tipo') ? 'selected' : ''}} {{$proceso->Tipo == "PNC" ? 'selected' : ''}}>No Convencional</option>
                        <option value="ENS" {{"ENS" == old('Tipo') ? 'selected' : ''}} {{$proceso->Tipo == "ENS" ? 'selected' : ''}}>Ensayo</option>
                    </x-slot>
                    <x-slot name="message">
                        @if ($errors->has('Tipo'))
                            {{ $errors->first('Tipo') }}
                        @elseif (old('Tipo'))
                            Todo correcto
                        @endif
                    </x-slot>
                    <x-slot name="error">
                        @if ($errors->has('Tipo'))
                            is-invalid
                        @elseif (old('Tipo') && ! $errors->has('Tipo'))
                            is-valid
                        @endif
                    </x-slot>
                </x-form-input-select>

                <input type="hidden" name="Predeterminado" value="0">
                <x-form-input-checkbox>
                    <x-slot name="label">Predeterminado</x-slot>
                    <x-slot name="name">Predeterminado</x-slot>
                    <x-slot name="value">1</x-slot>
                    <x-slot name="color">black</x-slot>
                    <x-slot name="checked">
                        {{ old('Predeterminado', $proceso->Predeterminado) == 1 ? 'checked' : '' }}
                    </x-slot>
                </x-form-input-checkbox>
            </div>

        </x-slot>

        <x-slot name="buttons">
            <x-form-button>
                <x-slot name="text">Guardar</x-slot>
                <x-slot name="color">success</x-slot>
            </x-form-button>
            <x-button>
                <x-slot name="text">Cancelar</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('procesos.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>
</x-layout>