<div>
    <input type="hidden" name="city_id" value="{{ $cityId }}">

    <x-form-input-disabled>
        <x-slot name="label">Localidad</x-slot>
        <x-slot name="name"></x-slot>
        <x-slot name="placeholder"></x-slot>
        <x-slot name="value">{{ $cityName }}</x-slot>
    </x-form-input-disabled>
</div>
