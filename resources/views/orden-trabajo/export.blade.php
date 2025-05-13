<table>
    <thead>
        <tr>
            <th>Descripción</th>
            <th>Material</th>
            <th>Cant.</th>
            <th>Peso</th>
            <th>Trat.</th>
            <th>Dureza</th>
            <th>DSMIN</th>
            <th>DSMAX</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orden_trabajo->itemsOrdenTrabajo as $item_orden_trabajo)
            <tr>
                <td>{{ $item_orden_trabajo->Descripcion }}</td>
                <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                <td>{{ $item_orden_trabajo->Cantidad }}</td>
                <td>{{ $item_orden_trabajo->Peso }}</td>
                <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
                <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
                <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
            </tr>
        @endforeach
    </tbody>
</table>