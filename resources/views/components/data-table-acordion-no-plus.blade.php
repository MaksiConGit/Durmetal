<style>
  .table-condensed td,
  .table-condensed th {
    padding: 0.6rem 0.75rem;
    font-size: 1rem;
    white-space: nowrap;
  }

  .table-container {
    font-size: 1rem;
  }

  .expandable-body {
    transition: all 0.3s ease;
  }

  .expandable-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
  }

  .expandable-body.open .expandable-content {
    max-height: 500px; /* Ajusta según el contenido máximo esperado */
  }

  tr[data-widget="expandable-table"] {
    cursor: pointer;
  }

  @media (max-width: 768px) {
    .btn {
      font-size: 0.75rem;
      padding: 0.25rem 0.5rem;
    }

    .btn-primary {
      font-size: 0.875rem;
      padding: 0.4rem 0.8rem;
    }

    .d-flex {
      gap: 0.5rem;
    }

    .table-condensed td,
    .table-condensed th {
      padding: 0.4rem 0.5rem;
      font-size: 0.9rem;
    }
  }

  .asd {
    background-color: #dee2e6 !important;
    color: white !important;
  }
</style>


<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <div class="d-flex align-items-center justify-content-between">
        <h4 class="card-title mb-0">{{ $table_title }}</h4>
        <div class="d-flex">
          <a href="{{ $export_route }}" class="btn btn-primary btn-round me-2">
            <i class="fa fa-download"></i> Exportar
          </a>
        </div>
      </div>
    </div>

    <div class="table-responsive table-container accordion" id="accordionTabla">
      <table id="add-row" class="display table table-hover table-condensed">
        <thead>
          {{ $head_tr }}
        </thead>
        <tfoot>
          {{ $foot_tr }}
        </tfoot>
          {{ $body_tr }}
      </table>
    </div>
</div>

<script>
  $(document).ready(function () {
    $("#add-row").DataTable({
      pageLength: 5,
      scrollX: true
    });

    $("#addRowButton").click(function () {
      const action = '<td><div class="form-button-action"><button class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></button><button class="btn btn-link btn-danger"><i class="fa fa-times"></i></button></div></td>';
      $("#add-row")
        .DataTable()
        .row.add([
          $("#addName").val(),
          $("#addPosition").val(),
          $("#addOffice").val(),
          action,
        ])
        .draw();
      $("#addRowModal").modal("hide");
    });

    // Animación expandible
    document.querySelectorAll('tr[data-widget="expandable-table"]').forEach(row => {
      row.addEventListener('click', () => {
        const nextRow = row.nextElementSibling;
        const isOpen = nextRow.classList.contains('open');

        nextRow.classList.toggle('open', !isOpen);
        row.setAttribute('aria-expanded', !isOpen);
      });
    });
  });
</script>




{{-- <div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-body p-0">
        <table class="table table-hover">
          <thead>
            <tr class="bg-dark text-white">
              <th>ID</th>
              <th>Cliente</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <!-- Fila principal -->
            <tr data-widget="expandable-table" aria-expanded="false">
              <td>1</td>
              <td>
                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                Juan Pérez
              </td>
              <td><span class="badge badge-success">Activo</span></td>
            </tr>
            <!-- Subfilas -->
            <tr class="expandable-body">
              <td colspan="3">
                <div class="p-0">
                  <table class="table table-sm mb-0">
                    <thead>
                      <tr class="bg-secondary text-white">
                        <th>ID Pedido</th>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Importe</th>
                        <th>Importe</th>
                        <th>Importe</th>
                        <th>Importe</th>
                        <th>Importe</th>
                        <th>Importe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>101</td>
                        <td>2024-08-01</td>
                        <td>$1500</td>
                        <td>$1500</td>
                        <td>$1500</td>
                        <td>$1500</td>
                        <td>$1500</td>
                        <td>$1500</td>
                        <td>$1500</td>
                      </tr>
                      <tr>
                        <td>102</td>
                        <td>2024-08-15</td>
                        <td>$2300</td>
                        <td>$2300</td>
                        <td>$2300</td>
                        <td>$2300</td>
                        <td>$2300</td>
                        <td>$2300</td>
                        <td>$2300</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>

            <!-- Otro cliente -->
            <tr data-widget="expandable-table" aria-expanded="false">
              <td>2</td>
              <td>
                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                María Gómez
              </td>
              <td><span class="badge badge-warning">Pendiente</span></td>
            </tr>
            <tr class="expandable-body">
              <td colspan="3">
                <div class="p-0">
                  <table class="table table-sm table-bordered mb-0">
                    <thead>
                      <tr class="bg-secondary text-white">
                        <th>ID Pedido</th>
                        <th>Fecha</th>
                        <th>Importe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>201</td>
                        <td>2024-07-12</td>
                        <td>$900</td>
                      </tr>
                      <tr>
                        <td>202</td>
                        <td>2024-07-28</td>
                        <td>$1200</td>
                      </tr>
                      <tr>
                        <td>203</td>
                        <td>2024-08-10</td>
                        <td>$750</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>

  </div>
</div> --}}
