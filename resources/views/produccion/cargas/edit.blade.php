<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('cargas.index') }}">Carga</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Editar carga</a></li>
    </x-slot>
    <x-form>
        <x-slot name="card_title">Editar Carga</x-slot>
        <x-slot name="action">{{ route('cargas.update', $idsArray) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>
        <x-slot name="inputs">

            <x-data-table-no-plus>
                <x-slot name="table_title">Programaciones</x-slot>
                <x-slot name="export_route"></x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Descripcion</th>
                        <th>Razón Social</th>
                        <th>OTI</th>
                        <th>Programacion</th>
                        <th>RP</th>
                        <th>Cantidad</th>
                        <th>Apto</th>
                        <th>DMIN</th>
                        <th>DMAX</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @forelse ($programaciones as $index => $programacion)
                        <input type="hidden" name="programaciones[]" value="{{ $programacion->id }}">
                        <tr>
                            <td>{{ $programacion->itemOrdenTrabajo->Descripcion }}</td>
                            <td>
                                [{{ $programacion->itemOrdenTrabajo->ordenTrabajo->cliente->id }}]
                                {{$programacion->itemOrdenTrabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}
                            </td>
                            <td>{{ $programacion->itemOrdenTrabajo->ordenTrabajo->Numero }}/{{ $programacion->itemOrdenTrabajo->ItemNumero }}</td>
                            <td>{{ $programacion->tipoProgramacion->Nombre }}</td>
                            <td>{{ $programacion->Reproceso == 0 ? '' : 'RP' }}</td>
                            <td>{{ $programacion->Cantidad }}</td>
                            <td>{{ $programacion->Apto == 'SI' ? 'APTO' : ''}}</td>
                            <td>{{ $programacion->DurezaMinima }}</td>
                            <td>{{ $programacion->DurezaMaxima }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="12">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Descripcion</th>
                        <th>Razón Social</th>
                        <th>OTI</th>
                        <th>Programacion</th>
                        <th>RP</th>
                        <th>Cantidad</th>
                        <th>Apto</th>
                        <th>DMIN</th>
                        <th>DMAX</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

            <div class="col-md-12 mb-3">

                <div class="row">

                    <div class="col-md-6">

                        <x-form-input-select>
                            <x-slot name="label">Programación</x-slot>
                            <x-slot name="name">IdTipoProgramacion</x-slot>
                            <x-slot name="option">
                                @foreach ($tipos_programacion as $tipo_programacion)
                                    <option value="{{$tipo_programacion->id}}"
                                        {{$tipo_programacion->id == old('IdTipoProgramacion') ? 'selected' : ''}} 
                                        {{$tipo_programacion->id == $primer_programacion->tipoProgramacion->id ? 'selected' : ''}}>
                                        {{$tipo_programacion->Nombre}}
                                    </option>
                                @endforeach
                            </x-slot>
                            <x-slot name="message">
                                @if ($errors->has('IdTipoProgramacion'))
                                    {{ $errors->first('IdTipoProgramacion') }}
                                @elseif (old('IdTipoProgramacion'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('IdTipoProgramacion'))
                                    is-invalid
                                @elseif (old('IdTipoProgramacion') && ! $errors->has('IdTipoProgramacion'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-select>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <x-form-input-datetime-local>
                            <x-slot name="label">Fecha Carga</x-slot>
                            <x-slot name="name">FechaCarga</x-slot>
                            <x-slot name="value">{{ old('FechaCarga', \Carbon\Carbon::parse($primer_programacion->FechaCarga)->format('Y-m-d\TH:i')) }}</x-slot>
                            <x-slot name="message">
                                @if ($errors->has('FechaCarga'))
                                    {{ $errors->first('FechaCarga') }}
                                @elseif (old('FechaCarga'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('FechaCarga'))
                                    is-invalid
                                @elseif (old('FechaCarga') && ! $errors->has('FechaCarga'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-datetime-local>
                    </div>

                    <div class="col-md-3">
                        <x-form-input-datetime-local>
                            <x-slot name="label">Fecha Descarga</x-slot>
                            <x-slot name="name">FechaDescarga</x-slot>
                            <x-slot name="value">{{ old('FechaDescarga', \Carbon\Carbon::parse($primer_programacion->FechaDescarga)->format('Y-m-d\TH:i')) }}</x-slot>
                            <x-slot name="message">
                                @if ($errors->has('FechaDescarga'))
                                    {{ $errors->first('FechaDescarga') }}
                                @elseif (old('FechaDescarga'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('FechaDescarga'))
                                    is-invalid
                                @elseif (old('FechaDescarga') && ! $errors->has('FechaDescarga'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-date-datetime-local>
                    </div>

                    <div class="col-md-6">
                        <x-form-input-select>
                            <x-slot name="label">Ejec. Por Operador</x-slot>
                            <x-slot name="name">EjecutadoPorOperador</x-slot>
                            <x-slot name="option">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}"
                                        {{$usuario->id == old('EjecutadoPorOperador') ? 'selected' : ''}} 
                                        {{$usuario->id == $primer_programacion->ejecutadoPorOperador->id ? 'selected' : ''}}>
                                        {{$usuario->name}}
                                    </option>                            
                                @endforeach
                            </x-slot>
                            <x-slot name="message">
                                @if ($errors->has('EjecutadoPorOperador'))
                                    {{ $errors->first('EjecutadoPorOperador') }}
                                @elseif (old('EjecutadoPorOperador'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('EjecutadoPorOperador'))
                                    is-invalid
                                @elseif (old('EjecutadoPorOperador') && ! $errors->has('EjecutadoPorOperador'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <x-form-input-radio>
                            <x-slot name="label">Horno</x-slot>
                            <x-slot name="inputs">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno1" value="1" checked/>
                                    <label class="form-check-label" for="horno1">H1</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno2" value="2" 
                                    {{2 == $primer_programacion->NumeroHorno ? 'checked' : ''}}/>
                                    <label class="form-check-label" for="horno2">H2</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno3" value="3"
                                    {{3 == $primer_programacion->NumeroHorno ? 'checked' : ''}} />
                                    <label class="form-check-label" for="horno3">H3</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno4" value="4"
                                    {{4 == $primer_programacion->NumeroHorno ? 'checked' : ''}} />
                                    <label class="form-check-label" for="horno4">H4</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno5" value="5"
                                    {{5 == $primer_programacion->NumeroHorno ? 'checked' : ''}} />
                                    <label class="form-check-label" for="horno5">H5</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno6" value="6"
                                    {{6 == $primer_programacion->NumeroHorno ? 'checked' : ''}} />
                                    <label class="form-check-label" for="horno6">H6</label>
                                </div>
                            </x-slot>
                        </x-form-input-radio>
                    </div>

                    <div class="col-md-3">
                        <x-form-input-default>
                            <x-slot name="label">Temperatura</x-slot>
                            <x-slot name="name">Temperatura</x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value">{{ old('Temperatura', $primer_programacion->Temperatura) }}</x-slot>
                            <x-slot name="message">
                                @if ($errors->has('Temperatura'))
                                    {{ $errors->first('Temperatura') }}
                                @elseif (old('Temperatura'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('Temperatura'))
                                    is-invalid
                                @elseif (old('Temperatura') && ! $errors->has('Temperatura'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-default>
                    </div>

                    <div class="col-md-3">
                        <x-form-input-select>
                            <x-slot name="label">Medio Enfriamiento</x-slot>
                            <x-slot name="name">IdMedioEnfriamiento</x-slot>
                            <x-slot name="option">
                                @foreach ($medios_enfriamiento as $medio_enfriamiento)
                                    <option value="{{ $medio_enfriamiento->id }}" 
                                        {{$medio_enfriamiento->id == old('IdMedioEnfriamiento') ? 'selected' : ''}} 
                                        {{$medio_enfriamiento->id == $primer_programacion->medioEnfriamiento->id ? 'selected' : ''}}>
                                        {{$medio_enfriamiento->Nombre}}
                                    </option>                            
                                @endforeach
                            </x-slot>
                            <x-slot name="message">
                                @if ($errors->has('IdMedioEnfriamiento'))
                                    {{ $errors->first('IdMedioEnfriamiento') }}
                                @elseif (old('IdMedioEnfriamiento'))
                                    Todo correcto
                                @endif
                            </x-slot>
                            <x-slot name="error">
                                @if ($errors->has('IdMedioEnfriamiento'))
                                    is-invalid
                                @elseif (old('IdMedioEnfriamiento') && ! $errors->has('IdMedioEnfriamiento'))
                                    is-valid
                                @endif
                            </x-slot>
                        </x-form-input-select>
                    </div>

                </div>

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
                <x-slot name="href">{{ route('cargas.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>

</x-layout>