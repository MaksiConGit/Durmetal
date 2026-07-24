<div>
    <x-layout2>
        <x-slot name="title">Programación de la Producción</x-slot>

        <form action="{{ route('programacion.store') }}" method="POST">
            @csrf

            <x-simple-table2>
                <x-slot name="thead">
                    <tr>
                        <th>DESCRIPCION</th>
                        <th>PROGRAMACION</th>
                        <th>A PROGRAMAR</th>
                        <th>RP</th>
                        <th>RAZON SOCUAL</th>
                        <th>FECHA</th>
                        <th>OTI</th>
                        <th>CANT.</th>
                        <th>PESO</th>
                        <th>TRAT.</th>
                        <th>MATERIAL</th>
                        <th>DUREZA</th>
                        <th>DSMIN - DSMAX</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">

                    @foreach ($items as $index => $item_orden_trabajo)
                        @livewire('item-programacion-row', ['item' => $item_orden_trabajo, 'index' => $index], key($item_orden_trabajo->id))
                    @endforeach
                    
                    @php
                        $filasFaltantes = max(0, 10 - count($items));
                    @endphp

                    @for ($i = 6; $i < $filasFaltantes; $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor

                </x-slot>
            </x-simple-table2>

            <div class="row mt-3">
                <div class="col-3">
                    <h5 class="text-bold">PROGRAMACION</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="form-group mb-0">
                        <select name="IdTipoProgramacion" id="" class="form-control form-control-sm" wire:model.live="IdTipoProgramacion">
                            @foreach ($tipos_programacion as $tipo_programacion)
                                <option value="{{$tipo_programacion->id}}" {{$tipo_programacion->id == old('IdTipoProgramacion', $IdTipoProgramacion) ? 'selected' : ''}}>{{$tipo_programacion->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-3">
                    <h5 class="text-bold">CARGA</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">FECHA CARGA</label>
                        <input type="datetime-local" id="filtro1" name="FechaCarga" class="form-control form-control-sm" value="{{ old('FechaCarga', now()->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group mb-0">
                        <label for="filtro2" class="font-weight-normal">FECHA DESCARGA</label>
                        <input type="datetime-local" id="filtro2" name="FechaDescarga" class="form-control form-control-sm" value="{{ old('FechaDescarga') }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-0">
                        <label for="filtro3" class="font-weight-normal">EJEC. POR OPERADOR</label>
                        <select name="EjecutadoPorOperador" id="filtro3" class="form-control form-control-sm">
                            @foreach ($usuarios as $usuario)
                                <option value="{{$usuario->id}}" {{$usuario->id == old('EjecutadoPorOperador') ? 'selected' : ''}}>{{$usuario->Nombre}}</option>                            
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="row mt-3">

                <div class="col-6">

                    <label class="font-weight-normal">HORNO</label>

                    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio1" name="NumeroHorno" value="1" checked>
                            <label for="customRadio1" class="custom-control-label font-weight-normal">H1</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio2" name="NumeroHorno" value="2">
                            <label for="customRadio2" class="custom-control-label font-weight-normal">H2</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio3" name="NumeroHorno" value="3">
                            <label for="customRadio3" class="custom-control-label font-weight-normal">H3</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio4" name="NumeroHorno" value="4">
                            <label for="customRadio4" class="custom-control-label font-weight-normal">H4</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio5" name="NumeroHorno" value="5">
                            <label for="customRadio5" class="custom-control-label font-weight-normal">H5</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio6" name="NumeroHorno" value="6">
                            <label for="customRadio6" class="custom-control-label font-weight-normal">H6</label>
                        </div>
                    </div>

                </div>

                <div class="col-3">
                    <div class="form-group mb-0">
                        <label for="filtro4" class="font-weight-normal">TEMPERATURA</label>
                        <input type="number" id="filtro4" name="Temperatura" class="form-control form-control-sm" value="{{ old('Temperatura', $Temperatura) }}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group mb-0">
                        <label for="filtro5" class="font-weight-normal">MEDIO ENFRIAMIENTO</label>
                        <select name="IdMedioEnfriamiento" id="filtro5" class="form-control form-control-sm">
                            @foreach ($medios_enfriamiento as $medio_enfriamiento)
                                <option value="{{ $medio_enfriamiento->id }}" {{$medio_enfriamiento->id == old('IdMedioEnfriamiento', $IdMedioEnfriamiento) ? 'selected' : ''}}>{{$medio_enfriamiento->Nombre}}</option>                            
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between mt-3">
                <a class="btn btn-app bg-primary" href="{{ route('programacion.index') }}">
                    <i class="fas fa-arrow-left"></i> Atrás
                </a>

                <button class="btn btn-app bg-primary">
                    <i class="fas fa-floppy-disk"></i> Guardar
                </button>
            </div>

        </form>

    </x-layout2>

</div>
