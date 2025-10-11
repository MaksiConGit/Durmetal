<x-layout2>
    <x-slot name="title">NUEVO GASTO</x-slot>

    <form action="{{ route('otros-egresos.otros-egresos.store') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-2"></div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="IdCuentaOtrosEgresos" class="font-weight-normal">CUENTA</label>
                    <select name="IdCuentaOtrosEgresos" id="" class="form-control form-control-sm">
                        @foreach ($cuentas_otros_egresos as $padre)
                            <option value="{{ $padre->id }}"
                                {{ old('IdCuentaOtrosEgresos') == $padre->id ? 'selected' : '' }}>
                                {{ $padre->Nombre }}
                            </option>
                            @foreach ($padre->hijos as $hijo)
                                <option value="{{ $hijo->id }}"
                                    {{ old('IdCuentaOtrosEgresos') == $hijo->id ? 'selected' : '' }}>
                                    {{$padre->Nombre}} - {{ $hijo->Nombre }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="Fecha" class="font-weight-normal">FECHA DEVENGADO</label>
                    <input type="date" id="Fecha" name="Fecha" class="form-control form-control-sm" value="{{old('Fecha', now()->toDateString())}}">
                </div>
            </div>
            <div class="col-2 mb-3"></div>


            <div class="col-2 mb-3"></div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="FechaPago" class="font-weight-normal">FECHA PAGO</label>
                    <input type="date" id="FechaPago" name="FechaPago" class="form-control form-control-sm" value="{{ old('FechaPago', now()->toDateString()) }}">
                </div>
            </div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="Descripcion" class="font-weight-normal">DESCRIPCION</label>
                    <input type="text" id="Descripcion" name="Descripcion" class="form-control form-control-sm" value="{{old('Descripcion')}}">
                </div>
            </div>
            <div class="col-2 mb-3"></div>

            <div class="col-2 mb-3"></div>
            <div class="col-4 mb-3">
                <div class="form-group mb-0">
                    <label for="Importe" class="font-weight-normal">IMPORTE</label>
                    <input type="text" id="Importe" name="Importe" class="form-control form-control-sm" value="{{old('Importe')}}">
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-app bg-primary">
                        <i class="fas fa-floppy-disk"></i> Guardar
                    </button>

                    <a class="btn btn-app bg-primary" href="{{ route('otros-egresos.otros-egresos.index') }}">
                        <i class="fas fa-ban"></i> Cancelar
                    </a>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

    </form>

</x-layout2>