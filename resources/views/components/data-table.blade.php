<style>
    .table-condensed td,
    .table-condensed th {
      padding: 0.6rem 0.75rem;
      font-size: 1rem; /* Aumentado */
      white-space: nowrap;
    }
  
    .table-container {
      font-size: 1rem; /* Aumentado */
    }
  </style>
  
  <div class="container-fluid"> <!-- Cambiado de container a container-fluid -->
    <div class="page-inner">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">{{ $table_title }}</h4>
              <a href="{{ route('clients.create') }}" class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus"></i>
                {{ $add_text }}
              </a>
            </div>
          </div>
  
          <div class="table-responsive table-container">
            <table id="add-row" class="display table table-striped table-hover table-condensed">
              <thead>
                {{ $head_tr }}
              </thead>
              <tfoot>
                {{ $foot_tr }}
              </tfoot>
              <tbody>
                {{ $body_tr }}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    $(document).ready(function () {
      $("#add-row").DataTable({
        pageLength: 5,
        scrollX: true // Lo dejamos activado por si hay muchas columnas
      });
  
      var action = '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
  
      $("#addRowButton").click(function () {
        $("#add-row")
          .dataTable()
          .fnAddData([
            $("#addName").val(),
            $("#addPosition").val(),
            $("#addOffice").val(),
            action,
          ]);
        $("#addRowModal").modal("hide");
      });
    });
  </script>
  