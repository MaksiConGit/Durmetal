<x-layout>

    <div>
        <h2>Añadir cliente</h2>
    
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div>
                <label for="id">Código</label>
                <input type="text" name="id" id="id" required value="{{old('id', $next_id)}}">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" required value="{{old('name')}}">
            </div>
            <br>
            <div>
                @livewire('client-location')
            </div>
            <br>
            <div>
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" id="phone" required value="{{old('phone')}}">
                <label for="iva_condition_id">Condición IVA</label>
                <select name="iva_condition_id" id="iva_condition_id">
                    @foreach ($iva_conditions as $iva_condition)
                        <option value="{{ $iva_condition->id }}" {{$iva_condition->id == '1' ? 'selected' : ''}}>
                            {{ $iva_condition->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <br>
            <div>
                <label for="document_type_id">Tipo de Documento</label>
                <select name="document_type_id" id="document_type_id">
                    @foreach ($document_types as $document_type)
                        <option value="{{ $document_type->id }}" {{$document_type->id == '1' ? 'selected' : ''}}>
                            {{ $document_type->name }}
                        </option>
                    @endforeach
                </select>
                <label for="document_number">N° de Documento</label>
                <input type="text" name="document_number" id="document_number" required value="{{old('document_number')}}">
            </div>
            <br>
            <div>
                <label for="client_qualification_id">Calificación</label>
                <select name="client_qualification_id" id="client_qualification_id">
                    @foreach ($client_qualifications as $client_qualification)
                        <option value="{{ $client_qualification->id }}" {{$client_qualification->id == '1' ? 'selected' : ''}}>
                            {{ $client_qualification->name }}
                        </option>
                    @endforeach
                </select>
                <label for="balance">Saldo Transportado</label>
                <input type="text" name="balance" id="balance" required placeholder="0.00" value="{{old('balance')}}">
            </div>
            <div>
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                <label for="is_active">Activo</label>
            </div>
    
            <br>
    
            <label for="emails">Emails</label>
            <div>
                @for ($i = 0; $i < 6; $i++)
                    <input type="email" name="emails[]" value="{{ old('emails.' . $i) }}">
                    <br><br>
                @endfor
            </div>        
    
            <br>
            <button type="submit">Guardar</button>
            <a href="{{ route('clients.index') }}">Volver</a>
        </form> 
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
    </div>
</x-layout>