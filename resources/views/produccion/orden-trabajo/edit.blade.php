@livewire('orden-trabajo-edit',
            ['orden_trabajo' => $orden_trabajo,
            'items_orden_trabajo' => $items_orden_trabajo,
            'pto_ventas' => $pto_ventas,
        ])

{{-- <x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ingreso de materiales</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Editar Órden de Trabajo</a></li>
    </x-slot>
    <x-form>
        <x-slot name="card_title">Órden de Trabajo</x-slot>
        <x-slot name="action">{{ route('orden-trabajo.update', $orden_trabajo) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>
        <x-slot name="inputs">

    <div class="row mb-3 align-items-center">

        <div class="col-md-3">
            <x-form-input-select>
                <x-slot name="label">Punto de Venta</x-slot>
                <x-slot name="name">PuntoVenta</x-slot>
                <x-slot name="option">
                @foreach ($pto_ventas as $pto_venta)
                    <option value="{{$pto_venta->id}}" {{$pto_venta->id == session('PuntoVenta') ? 'selected' : ''}}>{{$pto_venta->Nombre}}</option>                            
                @endforeach
                </x-slot>
                <x-slot name="message">
                    @if ($errors->has('PuntoVenta'))
                        {{ $errors->first('PuntoVenta') }}
                    @elseif (old('PuntoVenta'))
                        Todo correcto
                    @endif
                </x-slot>
                <x-slot name="error">
                    @if ($errors->has('PuntoVenta'))
                        is-invalid
                    @elseif (old('PuntoVenta') && ! $errors->has('PuntoVenta'))
                        is-valid
                    @endif
                </x-slot>
            </x-form-input-select>
        </div>

        <div class="col-md-2">
            <x-form-input-default>
            <x-slot name="label">Número</x-slot>
            <x-slot name="name">Numero</x-slot>
            <x-slot name="placeholder"></x-slot>
            <x-slot name="value">{{old('Numero', session('Numero'))}}</x-slot>
            <x-slot name="message">
                @if ($errors->has('Numero'))
                    {{ $errors->first('Numero') }}
                @elseif (old('Numero'))
                    Todo correcto
                @endif
            </x-slot>
            <x-slot name="error">
                @if ($errors->has('Numero'))
                    is-invalid
                @elseif (old('Numero') && ! $errors->has('Numero'))
                    is-valid
                @endif
            </x-slot>
            </x-form-input-default>
        </div>

        <div class="col-md-1 d-flex justify-content-center">
            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded" 
                style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: 700;">
            OT
            </div>
        </div>

        <div class="col-md-3">
            <x-form-input-date>
                <x-slot name="label">Fecha de Emisión</x-slot>
                <x-slot name="name">FechaEmision</x-slot>
                <x-slot name="value">{{old('FechaEmision', session('FechaEmision'))}}</x-slot>
                <x-slot name="message">
                    @if ($errors->has('FechaEmision'))
                        {{ $errors->first('FechaEmision') }}
                    @elseif (old('FechaEmision'))
                        Todo correcto
                    @endif
                </x-slot>
                <x-slot name="error">
                    @if ($errors->has('FechaEmision'))
                        is-invalid
                    @elseif (old('FechaEmision') && ! $errors->has('FechaEmision'))
                        is-valid
                    @endif
                </x-slot>
            </x-form-input-date>
        </div>

        <div class="col-md-3">
            <x-form-input-default>
                <x-slot name="label">N° Remito Cliente</x-slot>
                <x-slot name="name">NumeroRemitoCliente</x-slot>
                <x-slot name="placeholder"></x-slot>
                <x-slot name="value">{{old('NumeroRemitoCliente', session('NumeroRemitoCliente'))}}</x-slot>
                <x-slot name="message">
                    @if ($errors->has('NumeroRemitoCliente'))
                        {{ $errors->first('NumeroRemitoCliente') }}
                    @elseif (session()->has('_old_input') && ! $errors->has('NumeroRemitoCliente'))
                        Todo correcto
                    @endif
                </x-slot>
                <x-slot name="error">
                    @if ($errors->has('NumeroRemitoCliente'))
                        is-invalid
                    @elseif (session()->has('_old_input') && ! $errors->has('NumeroRemitoCliente'))
                        is-valid
                    @endif
                </x-slot>
            </x-form-input-default>
        </div>

    </div>

    @livewire('buscar-codigo-cliente', ['id_cliente' => session('IdCliente')])

    <x-data-table-js>
        <x-slot name="table_title">Items Órden de Trabajo</x-slot>
        <x-slot name="export_route">{{ route('orden-trabajo.export', $orden_trabajo->id) }}</x-slot>
        <x-slot name="create_route">{{ route('item-orden-trabajo.create', $orden_trabajo) }}</x-slot>
        <x-slot name="add_text">Añadir Item</x-slot>
        <x-slot name="js">onclick="redirigirConInputs()"</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Descripción</th>
                <th>Material</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>Trat.</th>
                <th>Dureza</th>
                <th>DSMIN</th>
                <th>DSMAX</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">

            @forelse ($items_orden_trabajo as $item_orden_trabajo)
                <tr>
                    <td>{{ $item_orden_trabajo->Descripcion }}</td>
                    <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->Cantidad }}</td>
                    <td>{{ $item_orden_trabajo->Peso }}</td>
                    <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
                    <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                    <td class="text-start align-middle">
                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                            <a
                                href="{{ route('item-orden-trabajo.edit', $item_orden_trabajo->id) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar ítem"
                            >
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <button 
                                type="button"
                                class="btn btn-link btn-danger p-0"
                                data-bs-toggle="tooltip"
                                title="Eliminar ítem"
                                onclick="confirmDelete({{ $item_orden_trabajo->id }})"
                            >
                                <i class="fa fa-times fa-lg"></i>
                            </button>
                        </div>
                    </td>
                        
                </tr>
            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Descripción</th>
                <th>Material</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>Trat.</th>
                <th>Dureza</th>
                <th>DSMIN</th>
                <th>DSMAX</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
    </x-data-table-js>

    </x-slot>
    <x-slot name="buttons">
        <div class="d-flex justify-content-end gap-2">
            <x-form-button>
                <x-slot name="text">Guardar</x-slot>
                <x-slot name="color">success</x-slot>
            </x-form-button>
            <x-button>
                <x-slot name="text">Cancelar</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('index') }}</x-slot>
            </x-button>
        </div>
    </x-slot>
  </x-form>

      <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>


    <script>
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este ítem?')) {
                const form = document.getElementById('delete-form');
                form.action = "{{ route('item-orden-trabajo.destroy', ':id') }}".replace(':id', id);
                form.submit();
            }
        }
    </script>

  <script>
    
    function redirigirConInputs() {
    const ordenTrabajoId = @json($orden_trabajo->id);

    const puntoVenta = document.querySelector('[name="PuntoVenta"]').value;
    const idCliente = document.querySelector('[name="IdCliente"]').value;
    const numero = document.querySelector('[name="Numero"]').value;
    const fechaEmision = document.querySelector('[name="FechaEmision"]').value;
    const numeroRemitoCliente = document.querySelector('[name="NumeroRemitoCliente"]').value;

    const url = new URL(`{{ url('/item-orden-trabajo/create') }}/${ordenTrabajoId}`);
    url.searchParams.append('PuntoVenta', puntoVenta);
    url.searchParams.append('IdCliente', idCliente);
    url.searchParams.append('Numero', numero);
    url.searchParams.append('FechaEmision', fechaEmision);
    url.searchParams.append('NumeroRemitoCliente', numeroRemitoCliente);

    window.location.href = url.toString();
  }
  </script>

</x-layout> --}}