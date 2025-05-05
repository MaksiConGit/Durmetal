<div>
    <x-form-input-select-livewire>
        <x-slot name="label">Código Postal</x-slot>
        <x-slot name="livewire">wire:change="seleccionarCp($event.target.value)"</x-slot>
        <x-slot name="name">CP</x-slot>
        <x-slot name="option">
            <option value="" selected hidden></option>
            @foreach ($cities as $city)
                <option value="{{ $city->CP }}" {{ old('CP') == $city->CP ? 'selected' : '' }}>
                    {{ $city->id }} | {{ $city->CP }} | {{ $city->Nombre }}
                </option>
            @endforeach
        </x-slot>
    </x-form-input-select>

    <x-form-input-disabled>
        <x-slot name="label">Provincia</x-slot>
        <x-slot name="name"></x-slot>
        <x-slot name="placeholder"></x-slot>
        <x-slot name="value">{{ $provinceName }}</x-slot>
    </x-form-input-disabled>
</div>
