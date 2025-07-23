<x-layout>
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-dollar-sign"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ficha del Cliente</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ver</a></li>
    </x-slot>

    <x-panel-horizontal-7>
        <x-slot name="title">({{$cliente->id}}) {{$cliente->Nombre}}</x-slot>
        
        <x-slot name="panel1">Órdenes de Trabajo</x-slot>
        <x-slot name="body1">

            <x-data-table-acordion>
                <x-slot name="table_title">Órdenes de Trabajo</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>
                <x-slot name="create_route">{{ route('ventas.ficha-del-cliente-orden.create', $cliente) }}</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Impresiones</th>
                        <th>Correos</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($ordenes_trabajo as $index => $orden_trabajo)
                        <tr class="border-t bg-gray-50 toggle-expand" data-id="ot{{ $orden_trabajo->id }}" style="cursor:pointer;" aria-expanded="false">
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('orden-trabajo.edit', $orden_trabajo->id) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar órden de trabajo"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <button 
                                        type="button"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar órden de trabajo"
                                        onclick="confirmDelete({{ $orden_trabajo->id }}, {{ $cliente->id }})"
                                    >
                                        <i class="fa fa-times fa-lg"></i>
                                    </button>
                                </div>
                            </td>
                            <td>{{ $orden_trabajo->FechaEmision }}</td>
                            <td>{{ $orden_trabajo->NumeroCompleto }}</td>
                            <td>{{ $orden_trabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
                            <td>{{ $orden_trabajo->Estado }}</td>
                            <td>{{ $orden_trabajo->CantidadImpresiones }}</td>
                            <td>{{ $orden_trabajo->CantidadEnviosPorCorreo }}</td>
                        </tr>

                        <tr class="expandable-body" data-for="ot{{ $orden_trabajo->id }}" style="display: none;">

                            <td colspan="12">

                                <x-card-no-buttons>

                                    <x-slot name="body">

                                        <x-data-table-no-plus-no-export>
                                            <x-slot name="table_title">Items Órden Trabajo</x-slot>
                                            <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                                            <x-slot name="add_text">Añadir Item</x-slot>

                                            <x-slot name="head_tr">
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Descripción</th>
                                                    <th>Material</th>
                                                    <th>Cant.</th>
                                                    <th>Peso</th>
                                                    <th>Trat.</th>
                                                    <th>Dureza</th>
                                                    <th>DSMIN</th>
                                                    <th>DSMAX</th>
                                                    <th>Estado</th>
                                                    <th>CC</th>
                                                    <th>Cert.</th>
                                                    <th>Nota de Envío</th>
                                                </tr>
                                            </x-slot>

                                            <x-slot name="body_tr">

                                                @forelse ($orden_trabajo->itemsOrdenTrabajo as $index => $item_orden_trabajo)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item_orden_trabajo->Descripcion }}</td>
                                                        <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                                                        <td>{{ $item_orden_trabajo->Cantidad }}</td>
                                                        <td>{{ $item_orden_trabajo->Peso }}</td>
                                                        <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                                                        <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                                                        <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
                                                        <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                                                        <td>{{ $item_orden_trabajo->Estado }}</td>
                                                        <td>{{ $item_orden_trabajo->CodigoComplejidad }}</td>
                                                        <td class="text-start align-middle">
                                                            @if ($item_orden_trabajo->Estado == 'APROBADO')
                                                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                                                    <a
                                                                        {{-- href="{{ route('programacion.print', $programacion->id) }}" --}}
                                                                        class="btn btn-link btn-secondary p-0"
                                                                        data-bs-toggle="tooltip"
                                                                        title="Imprimir programación"
                                                                    >
                                                                        <i class="fa fa-print fa-lg"></i>
                                                                    </a>
                                                                    <a
                                                                        {{-- href="{{ route('programacion.sendEmail', $programacion->id) }}" --}}
                                                                        class="btn btn-link btn-info p-0"
                                                                        data-bs-toggle="tooltip"
                                                                        title="Enviar por correo"
                                                                    >
                                                                        <i class="fa fa-envelope fa-lg"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="12">No se encontraron resultados.</td></tr>
                                                @endforelse
                                            </x-slot>

                                            <x-slot name="foot_tr">
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Descripción</th>
                                                    <th>Material</th>
                                                    <th>Cant.</th>
                                                    <th>Peso</th>
                                                    <th>Trat.</th>
                                                    <th>Dureza</th>
                                                    <th>DSMIN</th>
                                                    <th>DSMAX</th>
                                                    <th>Estado</th>
                                                    <th>CC</th>
                                                    <th>Cert.</th>
                                                    <th>Nota de Envío</th>
                                                </tr>
                                            </x-slot>
                                        </x-data-table-no-plus-no-export>
                                    </x-slot>
                                </x-card-no-buttons>
                            </td>
                        </tr>

                    @empty
                        <tr><td colspan="12">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>Impresiones</th>
                        <th>Correos</th>
                    </tr>
                </x-slot>
            </x-data-table-acordion>

        </x-slot>


        <x-slot name="panel2">Notas de Envío</x-slot>

        <x-slot name="body2">

              <x-data-table-acordion>
                <x-slot name="table_title">Notas de Envío</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Nota de Envío</x-slot>
                <x-slot name="create_route">{{ route('ventas.ficha-del-cliente-orden.create', $cliente) }}</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>N° Doc. Asociado</th>
                        <th>Razón Social</th>
                        <th>% Descuento</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Impresiones</th>
                        <th>Correos</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_de_envio as $index => $nota_de_envio)
                        <tr class="border-t bg-gray-50 toggle-expand" data-id="ne{{ $nota_de_envio->id }}" style="cursor:pointer;" aria-expanded="false">
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('orden-trabajo.edit', $nota_de_envio->id) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar órden de trabajo"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <button 
                                        type="button"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar órden de trabajo"
                                        onclick="confirmDelete({{ $nota_de_envio->id }}, {{ $cliente->id }})"
                                    >
                                        <i class="fa fa-times fa-lg"></i>
                                    </button>
                                </div>
                            </td>
                            <td>{{ $nota_de_envio->FechaEmision }}</td>
                            <td>{{ $nota_de_envio->NumeroCompleto }}</td>
                            <td></td>
                            <td>{{ $nota_de_envio->cliente->Nombre ?? 'Sin razón social' }}</td>
                            <td>{{  number_format($nota_de_envio->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{  number_format($nota_de_envio->Neto, 2, '.', '') }}</td>
                            <td>{{  number_format($nota_de_envio->IVA, 2, '.', '') }}</td>
                            <td>{{  number_format($nota_de_envio->Total, 2, '.', '') }}</td>
                            <td>{{ $nota_de_envio->Estado }}</td>
                            <td>{{ $nota_de_envio->CantidadImpresiones }}</td>
                            <td>{{ $nota_de_envio->CantidadEnviosPorCorreo }}</td>
                        </tr>

                        <tr class="expandable-body" data-for="ne{{ $nota_de_envio->id }}" style="display: none;">

                            <td colspan="12">

                                <x-card-no-buttons>

                                    <x-slot name="body">

                                        <x-data-table-no-plus-no-export>
                                            <x-slot name="table_title">Items Órden Trabajo</x-slot>
                                            <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                                            <x-slot name="add_text">Añadir Item</x-slot>

                                            <x-slot name="head_tr">
                                                <tr>
                                                    <th>N°</th>
                                                    <th>OTI</th>
                                                    <th>Descripción</th>
                                                    <th>Cant.</th>
                                                    <th>Peso</th>
                                                    <th>CC</th>
                                                    <th>Coefic.</th>
                                                    <th>Precio U.</th>
                                                    <th>% Desc</th>
                                                    <th>Total</th>
                                                </tr>
                                            </x-slot>

                                            <x-slot name="body_tr">

                                                @forelse ($nota_de_envio->itemsNotaEnvio as $index => $item_nota_envio)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item_nota_envio->itemOrdenTrabajo->ordenTrabajo->NumeroCompleto }}</td>
                                                        <td>{{ $item_nota_envio->Descripcion }}</td>
                                                        <td>{{ $item_nota_envio->Cantidad }}</td>
                                                        <td>{{ $item_nota_envio->Peso }}</td>
                                                        <td>{{ $item_nota_envio->CodigoComplejidad }}</td>
                                                        <td>{{ $item_nota_envio->Coeficiente }}</td>
                                                        <td>{{ $item_nota_envio->PrecioUnitario }}</td>
                                                        <td>{{ $item_nota_envio->PorcentajeDescuento }}</td>
                                                        <td>{{ $item_nota_envio->Total }}</td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="12">No se encontraron resultados.</td></tr>
                                                @endforelse
                                            </x-slot>

                                            <x-slot name="foot_tr">
                                                <tr>
                                                    <th>N°</th>
                                                    <th>OTI</th>
                                                    <th>Descripción</th>
                                                    <th>Cant.</th>
                                                    <th>Peso</th>
                                                    <th>CC</th>
                                                    <th>Coefic.</th>
                                                    <th>Precio U.</th>
                                                    <th>% Desc</th>
                                                    <th>Total</th>
                                                </tr>
                                            </x-slot>
                                        </x-data-table-no-plus-no-export>
                                    </x-slot>
                                </x-card-no-buttons>
                            </td>
                        </tr>

                    @empty
                        <tr><td colspan="12">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>N° Doc. Asociado</th>
                        <th>Razón Social</th>
                        <th>% Descuento</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Impresiones</th>
                        <th>Correos</th>
                    </tr>
                </x-slot>
            </x-data-table-acordion>

        </x-slot>

        
        <x-slot name="panel3">Facturas</x-slot>

        <x-slot name="body3">
            
            <x-data-table-acordion>
                <x-slot name="table_title">Facturas</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Factura</x-slot>
                <x-slot name="create_route">{{ route('ventas.ficha-del-cliente-orden.create', $cliente) }}</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Razón Social</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Impresiones</th>
                        <th>Correos</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($facturas as $index => $factura)
                        <tr class="border-t bg-gray-50 toggle-expand" data-id="fa{{ $factura->id }}" style="cursor:pointer;" aria-expanded="false">
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('orden-trabajo.edit', $factura->id) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar órden de trabajo"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                    <button 
                                        type="button"
                                        class="btn btn-link btn-danger p-0"
                                        data-bs-toggle="tooltip"
                                        title="Eliminar órden de trabajo"
                                        onclick="confirmDelete({{ $factura->id }}, {{ $cliente->id }})"
                                    >
                                        <i class="fa fa-times fa-lg"></i>
                                    </button>
                                </div>
                            </td>
                            <td>{{ $factura->FechaEmision }}</td>
                            <td>{{ $factura->NumeroCompleto }}</td>
                            <td>{{ $factura->RazonSocial }}</td>
                            <td>{{  number_format($factura->Neto, 2, '.', '') }}</td>
                            <td>{{  number_format($factura->IVA, 2, '.', '') }}</td>
                            <td>{{  number_format($factura->Total, 2, '.', '') }}</td>
                            <td>{{ $factura->Estado }}</td>
                            <td>{{ $factura->CantidadImpresiones }}</td>
                            <td>{{ $factura->CantidadEnviosPorCorreo }}</td>
                        </tr>

                        <tr class="expandable-body" data-for="fa{{ $factura->id }}" style="display: none;">

                            <td colspan="12">

                                <x-card-no-buttons>

                                    <x-slot name="body">

                                        <x-data-table-no-plus-no-export>
                                            <x-slot name="table_title">Items Órden Trabajo</x-slot>
                                            <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                                            <x-slot name="add_text">Añadir Item</x-slot>

                                            <x-slot name="head_tr">
                                                <tr>
                                                    <th>N°</th>
                                                    <th>OTI</th>
                                                    <th>Descripción</th>
                                                    <th>Cant.</th>
                                                    <th>Peso</th>
                                                    <th>CC</th>
                                                    <th>Coefic.</th>
                                                    <th>Precio U.</th>
                                                    <th>% Desc</th>
                                                    <th>Total</th>
                                                </tr>
                                            </x-slot>

                                            <x-slot name="body_tr">

                                                @forelse ($nota_de_envio->itemsNotaEnvio as $index => $item_nota_envio)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item_nota_envio->itemOrdenTrabajo->ordenTrabajo->NumeroCompleto }}</td>
                                                        <td>{{ $item_nota_envio->Descripcion }}</td>
                                                        <td>{{ $item_nota_envio->Cantidad }}</td>
                                                        <td>{{ $item_nota_envio->Peso }}</td>
                                                        <td>{{ $item_nota_envio->CodigoComplejidad }}</td>
                                                        <td>{{ $item_nota_envio->Coeficiente }}</td>
                                                        <td>{{ $item_nota_envio->PrecioUnitario }}</td>
                                                        <td>{{ $item_nota_envio->PorcentajeDescuento }}</td>
                                                        <td>{{ $item_nota_envio->Total }}</td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="12">No se encontraron resultados.</td></tr>
                                                @endforelse
                                            </x-slot>

                                            <x-slot name="foot_tr">
                                                <tr>
                                                    <th>N°</th>
                                                    <th>OTI</th>
                                                    <th>Descripción</th>
                                                    <th>Cant.</th>
                                                    <th>Peso</th>
                                                    <th>CC</th>
                                                    <th>Coefic.</th>
                                                    <th>Precio U.</th>
                                                    <th>% Desc</th>
                                                    <th>Total</th>
                                                </tr>
                                            </x-slot>
                                        </x-data-table-no-plus-no-export>
                                    </x-slot>
                                </x-card-no-buttons>
                            </td>
                        </tr>

                    @empty
                        <tr><td colspan="12">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Razón Social</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Impresiones</th>
                        <th>Correos</th>
                    </tr>
                </x-slot>
            </x-data-table-acordion>
        
        </x-slot>

        <x-slot name="panel4">Recibos</x-slot>

        <x-slot name="body4"></x-slot>

        <x-slot name="panel5">Notas de Crédito</x-slot>

        <x-slot name="body5"></x-slot>

        <x-slot name="panel6">Notas de Débito</x-slot>

        <x-slot name="body6"></x-slot>

        <x-slot name="panel7">Minutos</x-slot>

        <x-slot name="body7"></x-slot>

    </x-panel-horizontal-7>

    <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>


    <script>
        function confirmDelete(id, cliente) {
            if (confirm('¿Estás seguro de que quieres eliminar esta órden de trabajo?')) {
                const form = document.getElementById('delete-form');
                const url = "{{ route('orden-trabajo.destroy', ':id') }}"
                            .replace(':id', id) + "?cliente=" + cliente;
                form.action = url;
                form.submit();
            }
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-expand').forEach(row => {
            row.addEventListener('click', () => {
            const currentId = row.dataset.id;
            const expanded = row.getAttribute('aria-expanded') === 'true';

            document.querySelectorAll('.toggle-expand').forEach(r => r.setAttribute('aria-expanded', 'false'));
            document.querySelectorAll('.expandable-body').forEach(r => r.style.display = 'none');

            if (!expanded) {
                row.setAttribute('aria-expanded', 'true');
                const target = document.querySelector(`.expandable-body[data-for="${currentId}"]`);
                if (target) target.style.display = 'table-row';
            }
            });
        });
        });
    </script>

</x-layout>