<div>
    <table border="1" cellpadding="5" cellspacing="0">
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
                <th>Opciones</th>
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
                    <td>
                        <a href="{{ route('clients.edit', $client) }}">Editar</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <a href="{{ route('clients.create') }}">Nuevo cliente</a>
</div>

