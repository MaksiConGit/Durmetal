<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Programación</a></li>
    </x-slot>

    <form action="" method="POST">
      @csrf

      <x-data-table>
            <x-slot name="table_title">Items Órden de Trabajo</x-slot>
            <x-slot name="export_route"></x-slot>
            <x-slot name="create_route"></x-slot>
            <x-slot name="add_text">Añadir Item</x-slot>
            <x-slot name="head_tr">
                <tr>
                    <th>Descripción</th>
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
        
                @forelse ($items_orden_trabajo as $item_orden_trabajo)
                    <tr>
                        <td>{{ $item_orden_trabajo->Descripcion }}</td>
                        <td>{{ $item_orden_trabajo->ordenTrabajo->cliente->Nombre ?? 'Sin razón social' }}</td>
                        <td>{{ $item_orden_trabajo->FechaCreacion }}</td>
                        <td>?</td>
                        <td>{{ $item_orden_trabajo->Cantidad }}</td>
                        <td>{{ $item_orden_trabajo->Peso }}</td>
                        <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                        <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }} - {{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                    </tr>
                @empty
                    <tr><td colspan="11">No se encontraron resultados.</td></tr>
                @endforelse
            </x-slot>
            <x-slot name="foot_tr">
                <tr>
                    <th>Descripción</th>
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
        </x-data-table>
    </form>
   
</x-layout>