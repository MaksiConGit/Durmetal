<div>
    <label for="address">Domicilio</label>
    <input type="text" name="address" id="address" required value="{{old('address')}}">
    <label for="cp">Código Postal</label>
    <select wire:change="seleccionarCp($event.target.value)" name="cp" id="cp">
        <option value="" selected hidden></option>
        @foreach ($cities as $city)
            <option value="{{ $city->cp }}" {{ old('cp') == $city->cp ? 'selected' : '' }}>
                {{ $city->cp }}
            </option>
        @endforeach
    </select>
    
    <br><br>
    
    <label>Localidad</label>
    <input type="text" disabled value="{{ $cityName }}">
    <input type="text" name="city_id" hidden required value="{{ $city->id }}">
    
    <label>Provincia</label>
    <input type="text" disabled value="{{ $provinceName }}">
</div>