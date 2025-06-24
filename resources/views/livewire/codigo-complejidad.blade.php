<div class="row">
    <input type="hidden" name="IdTratamiento" value="{{ $tratamiento->id }}">

    <div class="col-md-2 mb-3">
        <x-form-input-default>
            <x-slot name="label">CC</x-slot>
            <x-slot name="name">CC</x-slot>
            <x-slot name="placeholder"></x-slot>
            <x-slot name="value">{{old('CC', $nextCodigo)}}</x-slot>
            <x-slot name="message">
                @if ($errors->has('CC'))
                    {{ $errors->first('CC') }}
                @elseif (old('CC'))
                    Todo correcto
                @endif
            </x-slot>
            <x-slot name="error">
                @if ($errors->has('CC'))
                    is-invalid
                @elseif (old('CC') && ! $errors->has('CC'))
                    is-valid
                @endif
            </x-slot>
        </x-form-input-default>
    </div>

    <div class="col-md-2 mb-3">
        <x-form-input-default-livewire>
            <x-slot name="label">Precio</x-slot>
            <x-slot name="name">Precio</x-slot>
            <x-slot name="placeholder">0.00</x-slot>
            <x-slot name="livewire">step="0.01" wire:model.live="precio"</x-slot>
            <x-slot name="value"></x-slot>
            <x-slot name="message">
                @if ($errors->has('Precio'))
                    {{ $errors->first('Precio') }}
                @elseif (old('Precio'))
                    Todo correcto
                @endif
            </x-slot>
            <x-slot name="error">
                @if ($errors->has('Precio'))
                    is-invalid
                @elseif (old('Precio') && ! $errors->has('Precio'))
                    is-valid
                @endif
            </x-slot>
        </x-form-input-default-livewire>
    </div>

    <div class="col-md-2 mb-3">
        <x-form-input-select>
            <x-slot name="label">Divisa</x-slot>
            <x-slot name="name">Divisa</x-slot>
            <x-slot name="option">
                <option value="" hidden></option>
                <option value="ARS" {{"ARS" == old('Divisa') ? 'selected' : ''}}>ARS</option>
                <option value="USD" {{"USD" == old('Divisa') ? 'selected' : ''}}>USD</option>
            </x-slot>
            <x-slot name="message">
                @if ($errors->has('Divisa'))
                    {{ $errors->first('Divisa') }}
                @elseif (old('Divisa'))
                    Todo correcto
                @endif
            </x-slot>
            <x-slot name="error">
                @if ($errors->has('Divisa'))
                    is-invalid
                @elseif (old('Divisa') && ! $errors->has('Divisa'))
                    is-valid
                @endif
            </x-slot>
        </x-form-input-select>
    </div>

    <div class="col-md-3 mb-3">
        <x-form-input-default-livewire>
            <x-slot name="label">% Coeficiente</x-slot>
            <x-slot name="name">PorcentajeCoeficiente</x-slot>
            <x-slot name="placeholder">0.00</x-slot>
            <x-slot name="livewire">step="0.01" wire:model.live="porcentaje"</x-slot>
            <x-slot name="value"></x-slot>
            <x-slot name="message">
                @if ($errors->has('PorcentajeCoeficiente'))
                    {{ $errors->first('PorcentajeCoeficiente') }}
                @elseif (old('PorcentajeCoeficiente'))
                    Todo correcto
                @endif
            </x-slot>
            <x-slot name="error">
                @if ($errors->has('PorcentajeCoeficiente'))
                    is-invalid
                @elseif (old('PorcentajeCoeficiente') && ! $errors->has('PorcentajeCoeficiente'))
                    is-valid
                @endif
            </x-slot>
        </x-form-input-default-livewire>
    </div>

    <div class="col-md-3 mb-3">
        <x-form-input-default-livewire>
            <x-slot name="label">Coeficiente</x-slot>
            <x-slot name="name">Coeficiente</x-slot>
            <x-slot name="placeholder">0.000</x-slot>
            <x-slot name="livewire">step="0.01" wire:model.live="coeficiente"</x-slot>
            <x-slot name="value"></x-slot>
            <x-slot name="message">
                @if ($errors->has('Coeficiente'))
                    {{ $errors->first('Coeficiente') }}
                @elseif (old('Coeficiente'))
                    Todo correcto
                @endif
            </x-slot>
            <x-slot name="error">
                @if ($errors->has('Coeficiente'))
                    is-invalid
                @elseif (old('Coeficiente') && ! $errors->has('Coeficiente'))
                    is-valid
                @endif
            </x-slot>
        </x-form-input-default-livewire>
    </div>

    <div class="col-md-12 mb-3">
        <x-form-input-default>
            <x-slot name="label">Descripción</x-slot>
            <x-slot name="name">Descripcion</x-slot>
            <x-slot name="placeholder"></x-slot>
            <x-slot name="value">{{old('Descripcion')}}</x-slot>
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
</div>