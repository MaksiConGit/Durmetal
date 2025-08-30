<div class="row">

    <div class="col-2"></div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="id" class="font-weight-normal">CODIGO</label>
            <input type="text" id="id" name="id" class="form-control form-control-sm" value="{{old('id', $client->id)}}">
        </div>
    </div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="Nombre" class="font-weight-normal">NOMBRE</label>
            <input type="text" id="Nombre" name="Nombre" class="form-control form-control-sm" value="{{old('Nombre', $client->Nombre)}}">
        </div>
    </div>
    <div class="col-2 mb-3"></div>


    <div class="col-2 mb-3"></div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="Domicilio" class="font-weight-normal">DOMICILIO</label>
            <input type="text" id="Domicilio" name="Domicilio" class="form-control form-control-sm" value="{{old('Domicilio', $client->Domicilio)}}">
        </div>
    </div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="CP" class="font-weight-normal">CODIGO POSTAL</label>
            <input type="text" id="CP" name="CP" class="form-control form-control-sm" wire:model.live="cp">
        </div>
    </div>
    <div class="col-2 mb-3"></div>

    <div class="col-2 mb-3"></div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="IdLocalidad" class="font-weight-normal">LOCALIDAD</label>
            <input type="text" id="IdLocalidad" name="IdLocalidad" class="form-control form-control-sm" value="{{ $cityName }}" disabled>
            <input type="hidden" name="IdLocalidad" value="{{ $cityId }}">
        </div>
    </div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="" class="font-weight-normal">PROVINCIA</label>
            <input type="text" id="" name="" class="form-control form-control-sm" value="{{ $provinceName }}" disabled>
        </div>
    </div>
    <div class="col-2 mb-3"></div>


    <div class="col-2 mb-3"></div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="Telefono" class="font-weight-normal">TELEFONO</label>
            <input type="text" id="Telefono" name="Telefono" class="form-control form-control-sm" value="{{old('Telefono', $client->Telefono)}}">
        </div>
    </div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="IdCondicionIVA" class="font-weight-normal">CONDICION IVA</label>
            <select name="IdCondicionIVA" id="" class="form-control form-control-sm">
                @foreach ($condiciones_IVA as $condicion_IVA)
                    <option value="{{ $condicion_IVA->id }}" {{$condicion_IVA->id == $client->IdCondicionIVA ? 'selected' : ''}}>
                        {{ $condicion_IVA->Nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-2 mb-3"></div>

    <div class="col-2 mb-3"></div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="TipoDocumento" class="font-weight-normal">TIPO DOCUMENTO</label>
            <select name="TipoDocumento" id="" class="form-control form-control-sm">
                <option value="CUIT">CUIT</option>
                <option value="CUIL" {{$client->TipoDocumento == 'CUIL' ? 'selected' : ''}}>CUIL</option>
            </select>
        </div>
    </div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="NroDocumento" class="font-weight-normal">NRO DOCUMENTO</label>
            <input type="text" id="NroDocumento" name="NroDocumento" class="form-control form-control-sm" value="{{old('NroDocumemento', $client->NroDocumento)}}">
        </div>
    </div>
    <div class="col-2 mb-3"></div>

    <div class="col-2 mb-3"></div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="IdCalificacionCliente" class="font-weight-normal">CALIFICACION</label>
            <select name="IdCalificacionCliente" id="" class="form-control form-control-sm">
                @foreach ($calificaciones_cliente as $calificacion_cliente)
                    <option value="{{ $calificacion_cliente->id }}" {{$calificacion_cliente->id == $client->IdCalificacionCliente ? 'selected' : ''}}>
                        {{ $calificacion_cliente->Nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-4 mb-3">
        <div class="form-group mb-0">
            <label for="Saldo" class="font-weight-normal">SALDO TRANSPORTADO</label>
            <input type="text" id="Saldo" name="Saldo" class="form-control form-control-sm" value="{{old('Saldo', $client->Saldo )}}">
        </div>
    </div>
    <div class="col-2 mb-3"></div>
    
    <div class="col-2 mb-3"></div>
    <div class="col-4 mb-3">
        <div class="custom-control custom-checkbox">
            <input type="hidden" name="Activo" value="0">
            <input class="custom-control-input" type="checkbox" id="Activo" name="Activo" value="1" {{ $client->Activo == 1 ? 'checked' : '' }}>
            <label for="Activo" class="custom-control-label">ACTIVO</label>
        </div>
    </div>
    <div class="col-2 mb-3"></div>
    
</div>