<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
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
    </thead>
    <tbody>
        @foreach ($items_orden_trabajo as $item_orden_trabajo)
            <tr>
                <td>0</td>
                <td>0</td>
                <td>{{ $item_orden_trabajo->Descripcion }}</td>
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
            @endforeach
    </tbody>
</table>