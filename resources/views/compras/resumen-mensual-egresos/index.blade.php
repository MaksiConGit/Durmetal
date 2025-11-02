{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Resumen mensual de egresos</a></li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Desde Fecha</x-slot>
                        <x-slot name="livewire">wire:model.live="fecha_desde"</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date-livewire>
                </div>

                <div class="col-md-3">
                    <x-form-input-date-livewire>
                        <x-slot name="label">Hasta Fecha</x-slot>
                        <x-slot name="livewire">wire:model.live="fecha_hasta"</x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="name"></x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date-livewire>
                </div>

            </div>
        </div>
    </div>

    <x-data-table-no-plus>
        <x-slot name="table_title">Resumen mensual de egresos</x-slot>
        <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
        <x-slot name="add_text">Añadir Item</x-slot>

        <x-slot name="head_tr">
            <tr>
                <th>Cuenta</th>
                <th>Tipo</th>
                <th>Enero</th>
                <th>Febrero</th>
                <th>Marzo</th>
                <th>Abril</th>
                <th>Mayo</th>
                <th>Junio</th>
                <th>Julio</th>
                <th>Agosto</th>
                <th>Septiembre</th>
                <th>Octubre</th>
                <th>Noviembre</th>
                <th>Diciembre</th>
                <th>Total</th>
            </tr>
        </x-slot>

        <x-slot name="body_tr">

            @foreach ($cuentas_gastos as $cuenta_gastos)
                <tr>
                    <td>{{ $cuenta_gastos->Nombre }}</td>
                    <td>GASTOS</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                </tr>
            @endforeach

            @foreach ($cuentas_otros_egresos as $cuenta_otros_egresos)
                <tr>
                    <td>{{ $cuenta_otros_egresos->Nombre }}</td>
                    <td>OTROS EGRESOS</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                </tr>
            @endforeach

            <tr class="fw-bold">
                <td>SUBTOTAL MENSUAL</td>
                <td></td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
            </tr>
        </x-slot>

        <x-slot name="foot_tr">
            <tr>
                <th>Cuenta</th>
                <th>Tipo</th>
                <th>Enero</th>
                <th>Febrero</th>
                <th>Marzo</th>
                <th>Abril</th>
                <th>Mayo</th>
                <th>Junio</th>
                <th>Julio</th>
                <th>Agosto</th>
                <th>Septiembre</th>
                <th>Octubre</th>
                <th>Noviembre</th>
                <th>Diciembre</th>
                <th>Total</th>
            </tr>
        </x-slot>
    </x-data-table-no-plus>

</x-layout> --}}

<x-layout2>
    <x-slot name="title">Resumen mensual de egresos</x-slot>

    {{-- @livewire('listado-cheques-proveedores2') --}}

    <x-simple-table2>
    <x-slot name="filtros">
        <div class="row">

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">DESDE FECHA</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_desde" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">HASTA FECHA</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_hasta" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

        </div>
      </div>
    </x-slot>
    <x-slot name="thead">
        <tr>
            <th>CUENTA</th>
            <th>TIPO</th>
            <th>ENERO</th>
            <th>FEBRERO</th>
            <th>MARZO</th>
            <th>ABRIL</th>
            <th>MAYO</th>
            <th>JUNIO</th>
            <th>JULIO</th>
            <th>AGOSTO</th>
            <th>SEPTIEMBRE</th>
            <th>OCTUBRE</th>
            <th>NOVIEMBRE</th>
            <th>DICIEMBRE</th>
            <th>TOTAL</th>
        </tr>
    </x-slot>
    <x-slot name="tbody">

            @foreach ($cuentas_gastos as $cuenta_gastos)
                <tr>
                    <td>{{ $cuenta_gastos->Nombre }}</td>
                    <td>GASTOS</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                </tr>
            @endforeach

            @foreach ($cuentas_otros_egresos as $cuenta_otros_egresos)
                <tr>
                    <td>{{ $cuenta_otros_egresos->Nombre }}</td>
                    <td>OTROS EGRESOS</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                </tr>
            @endforeach

            <tr class="text-bold">
                <td>SUBTOTAL MENSUAL</td>
                <td></td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
                <td>{{ number_format(0, 2, '.', '') }}</td>
            </tr>

    </x-slot>
</x-simple-table2>

</x-layout2>