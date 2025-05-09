<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Domicilio</th>
            <th>Localidad</th>
            <th>Provincia</th>
            <th>Teléfono</th>
            <th>Condición IVA</th>
            <th>Tipo de Documento</th>
            <th>N° de Documento</th>
            <th>Activo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->Nombre }}</td>
                <td>{{ $client->Domicilio }}</td>
                <td>{{ $client->localidad->Nombre }}</td>
                <td>{{ $client->localidad->provincia->Nombre }}</td>
                <td>{{ $client->Telefono }}</td>
                <td>{{ $client->condicionIVA->Nombre }}</td>
                <td>{{ $client->TipoDocumento }}</td>
                <td>{{ $client->NroDocumento }}</td>
                <td>{{ $client->Activo == 1 ? 'Sí' : 'No' }}</td>  
            </tr>
        @endforeach
    </tbody>
</table>