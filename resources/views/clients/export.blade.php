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
                <td>{{ $client->name }}</td>
                <td>{{ $client->address }}</td>
                <td>{{ $client->city->name }}</td>
                <td>{{ $client->city->province->name }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->ivaCondition->name }}</td>
                <td>{{ $client->documentType->name }}</td>
                <td>{{ $client->document_number }}</td>
                <td>{{ $client->is_active == 1 ? 'Sí' : 'No' }}</td>  
            </tr>
        @endforeach
    </tbody>
</table>