<div>
    <label for="address">Domicilio</label>
    <input type="text" name="address" id="address" required value="{{old('address', $client->address)}}">
    <label for="cp">Código Postal</label>
    <select wire:change="seleccionarCp($event.target.value)" name="cp" id="cp">
        @foreach ($cities as $city)
            <option value="{{ old('cp', $city->cp) }}" {{ $city->id == $client->city_id ? 'selected' : '' }} >{{ $city->cp }}</option>
        @endforeach
    </select>
    
    <br><br>
    
    <label>Localidad</label>
    <input type="text" disabled value="{{ $cityName }}">
    <input type="text" hidden name="city_id" wire:model="city_id" required>
    
    <label>Provincia</label>
    <input type="text" disabled value="{{ $provinceName }}">
</div>