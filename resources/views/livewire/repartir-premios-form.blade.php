<div>
<div>
    <form action="{{ route('repartir-premios.store') }}" method="POST">
        @csrf

        <x-simple-table2>
            <x-slot name="filtros">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group mb-0">
                            <label for="Nombre" class="font-weight-normal">NOMBRE</label>
                            <input type="text" value="{{ old('Nombre') }}" id="Nombre" name="Nombre" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="FechaDesde" class="font-weight-normal">DESDE</label>
                            <input type="date" value="{{ old('FechaDesde', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}" id="FechaDesde" name="FechaDesde" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group mb-0">
                            <label for="FechaHasta" class="font-weight-normal">HASTA</label>
                            <input type="date" value="{{ old('FechaHasta', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}" id="FechaHasta" name="FechaHasta" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-0">
                            <label for="Estado" class="font-weight-normal">ESTADO</label>
                            <select name="Estado" id="Estado" class="form-control form-control-sm">
                                <option value="PENDIENTE" {{ old('Estado') == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                                <option value="COMPLETO" {{ old('Estado') == 'COMPLETO' ? 'selected' : '' }}>COMPLETO</option>
                            </select>
                        </div>
                    </div>
                </div>
                </div>
            </x-slot>
            <x-slot name="thead">
                <tr>
                    <th>EMPLEADO</th>
                    <th>BASE</th>
                    <th>INDICE BASE</th>
                    <th>COEFICIENTE</th>
                    <th>PREMIO</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                
                @foreach ($empleados as $usuario)
                    <tr>

                        <input type="hidden" name="IdUsuario[]" value="{{$usuario->id}}">

                        <td>{{ $usuario->name }}</td>
                        <td>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="PremioBase[]"
                                wire:model.live="bases.{{ $usuario->id }}" 
                                class="form-control" 
                                placeholder="0.00">
                        </td>
                        <td>
                        <input 
                            type="number" 
                            step="0.01"
                            name="IndiceBase[]"
                            wire:model.live="indiceBasePremios.{{ $usuario->id }}"
                            class="form-control" 
                            placeholder="0.00">
                        </td>
                        <td>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="Coeficiente[]"
                                wire:model.live="coeficientes.{{ $usuario->id }}" 
                                class="form-control" 
                                placeholder="1.00">
                        </td>
                        <td>
                            {{ number_format($premios[$usuario->id] ?? 0, 2, ',', '') }}
                            <input type="hidden" name="Premio[]" value="{{ number_format($premios[$usuario->id] ?? 0, 2, '.', '') }}">
                        </td>
                    </tr>
                @endforeach

                @php
                    $filasFaltantes = max(0, 10 - count($empleados));
                @endphp

                @for ($i = 0; $i < $filasFaltantes; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor

            </x-slot>

        </x-simple-table2>

    <div class="d-flex justify-content-end p-3">
        <div class="col-3">
            <div class="form-group mb-0">
                <label for="Nombre" class="font-weight-normal text-bold">PREMIOS OTORGADOS</label>
                <input type="text" id="Nombre" name="" disabled value="{{ number_format($totalPremios, 2, '.', '') }}" class="form-control form-control-sm">
                <input type="hidden" name="PremioTotal" value="{{$totalPremios}}">
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end p-3">
        <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
            <span class="text-white">Guardar</span>
            <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
        </button>

        <a class="btn btn-sidebar btn-sm bg-orange ml-2" href="{{ route('repartir-premios.index') }}">
            <span class="text-white">Cancelar</span>
            <i class="fas fa-xmark fa-fw text-white ml-2"></i>
        </a>
    </div>

</div>