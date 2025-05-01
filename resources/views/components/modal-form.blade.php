<!-- Botón para abrir el modal -->
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
    <i class="fa fa-plus"></i> Nuevo Cliente
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form action="{{ route('clients.store') }}" method="POST" class="modal-content">
        @csrf
  
        <div class="modal-header">
          <h5 class="modal-title" id="createClientLabel">Añadir cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
  
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-3">
              <label for="id" class="form-label">Código</label>
              <input type="text" name="id" id="id" class="form-control" required value="{{ old('id', $next_id) }}">
            </div>
            <div class="col-md-9">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
            </div>
  
            <div class="col-12">
              @livewire('client-location')
            </div>
  
            <div class="col-md-6">
              <label for="phone" class="form-label">Teléfono</label>
              <input type="text" name="phone" id="phone" class="form-control" required value="{{ old('phone') }}">
            </div>
            <div class="col-md-6">
              <label for="iva_condition_id" class="form-label">Condición IVA</label>
              <select name="iva_condition_id" id="iva_condition_id" class="form-select">
                @foreach ($iva_conditions as $iva_condition)
                  <option value="{{ $iva_condition->id }}" {{ $iva_condition->id == '1' ? 'selected' : '' }}>
                    {{ $iva_condition->name }}
                  </option>
                @endforeach
              </select>
            </div>
  
            <div class="col-md-6">
              <label for="document_type_id" class="form-label">Tipo de Documento</label>
              <select name="document_type_id" id="document_type_id" class="form-select">
                @foreach ($document_types as $document_type)
                  <option value="{{ $document_type->id }}" {{ $document_type->id == '1' ? 'selected' : '' }}>
                    {{ $document_type->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="document_number" class="form-label">N° de Documento</label>
              <input type="text" name="document_number" id="document_number" class="form-control" required value="{{ old('document_number') }}">
            </div>
  
            <div class="col-md-6">
              <label for="client_qualification_id" class="form-label">Calificación</label>
              <select name="client_qualification_id" id="client_qualification_id" class="form-select">
                @foreach ($client_qualifications as $client_qualification)
                  <option value="{{ $client_qualification->id }}" {{ $client_qualification->id == '1' ? 'selected' : '' }}>
                    {{ $client_qualification->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="balance" class="form-label">Saldo Transportado</label>
              <input type="text" name="balance" id="balance" class="form-control" required placeholder="0.00" value="{{ old('balance') }}">
            </div>
  
            <div class="col-12">
              <div class="form-check">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">Activo</label>
              </div>
            </div>
  
            <div class="col-12">
              <label for="emails" class="form-label">Emails</label>
              @for ($i = 0; $i < 6; $i++)
                <input type="email" name="emails[]" class="form-control mb-2" value="{{ old('emails.' . $i) }}">
              @endfor
            </div>
          </div>
  
          @if ($errors->any())
            <div class="alert alert-danger mt-3">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
  
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
  