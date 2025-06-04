<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Programación</a></li>
    </x-slot>

    <x-form>
        <x-slot name="card_title">Programar</x-slot>
        <x-slot name="action">{{ route('programacion.store') }}</x-slot>
        <x-slot name="method"></x-slot>
        <x-slot name="inputs">

            <x-data-table-no-plus>
                <x-slot name="table_title">Trabajos Seleccionados</x-slot>
                <x-slot name="export_route"></x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Descripción</th>
                        <th>Programacion</th>
                        <th>A programar</th>
                        <th>RP</th>
                        <th>Razón Social</th>
                        <th>Fecha</th>
                        <th>OTI</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Dureza</th>
                        <th>DSMIN - DSMAX</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @forelse ($items as $index => $item_orden_trabajo)
                        <tr>
                            <input type="hidden" name="ItemOrdenTrabajoIds[]" value="{{ $item_orden_trabajo->id }}">
                            <td>{{ $item_orden_trabajo->Descripcion }}</td>
                            <td>
                                <select name="" id="">
                                    <option value="">Nueva</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="Cantidad[]" id="" value="{{ number_format($item_orden_trabajo->Cantidad, 3, '.', '') }}">
                            </td>
                            <td>
                                <input type="hidden" name="Reproceso[{{$index}}]" value="0">
                                <input type="checkbox" name="Reproceso[{{$index}}]" id="Reproceso[{{$index}}]" value="1">
                            </td>
                            <td>{{ $item_orden_trabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
                            <td>{{ $item_orden_trabajo->FechaCreacion }}</td>
                            <td>{{ $item_orden_trabajo->ordenTrabajo->Numero }}/{{ $item_orden_trabajo->ItemNumero }}</td>
                            <td>{{ $item_orden_trabajo->Cantidad }}</td>
                            <td>{{ $item_orden_trabajo->Peso }}</td>
                            <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                            <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }} - {{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="12">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Descripción</th>
                        <th>Programacion</th>
                        <th>A programar</th>
                        <th>RP</th>
                        <th>Razón Social</th>
                        <th>Fecha</th>
                        <th>OTI</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Dureza</th>
                        <th>DSMIN - DSMAX</th>
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
                                    <option value="{{$tipo_programacion->id}}" {{$tipo_programacion->id == old('IdTipoProgramacion') ? 'selected' : ''}}>{{$tipo_programacion->Nombre}}</option>
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
                            <x-slot name="value">{{ old('FechaCarga', now()->format('Y-m-d\TH:i')) }}</x-slot>
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
                            <x-slot name="value">{{ old('FechaDescarga') }}</x-slot>
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
                                    <option value="{{$usuario->id}}" {{$usuario->id == old('EjecutadoPorOperador') ? 'selected' : ''}}>{{$usuario->name}}</option>                            
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
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno2" value="2" />
                                    <label class="form-check-label" for="horno2">H2</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno3" value="3" />
                                    <label class="form-check-label" for="horno3">H3</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno4" value="4" />
                                    <label class="form-check-label" for="horno4">H4</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno5" value="5" />
                                    <label class="form-check-label" for="horno5">H5</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="NumeroHorno" id="horno6" value="6" />
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
                            <x-slot name="value">{{ old('Temperatura', 850) }}</x-slot>
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
                                    <option value="{{ $medio_enfriamiento->id }}" {{$medio_enfriamiento->id == old('IdMedioEnfriamiento') ? 'selected' : ''}}>{{$medio_enfriamiento->Nombre}}</option>                            
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
                <x-slot name="href">{{ route('programacion.index') }}</x-slot>
            </x-button>
        </x-slot>
    </x-form>

</x-layout>