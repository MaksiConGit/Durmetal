<!-- /.row -->
<div class="row">
  <div class="col-12">
    <div class="card">
      @if(!empty($filtros))
        <div class="card-header">
          {{ $filtros }}
        </div>
      @endif

      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-head-fixed text-nowrap table-hover table-bordered table-striped table-sm compact-table">
          @if(!empty($thead))
            <thead>
              {{ $thead }}
            </thead>
          @endif
          <tbody>
            {{ $tbody }}
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
<!-- /.row -->

<style>
  /* 🔸 Compactar filas */
  .compact-table td,
  .compact-table th {
    padding: 0.25rem 0.4rem !important; /* reduce el alto de las filas */
    vertical-align: middle;
  }

  /* 🔸 Inputs e íconos más chicos */
  .compact-table input,
  .compact-table select,
  .compact-table button {
    height: 24px !important;
    font-size: 0.75rem !important;
    padding: 0 0.3rem !important;
  }

  /* 🔸 Íconos centrados */
  .compact-table .btn i {
    font-size: 0.8rem;
    vertical-align: middle;
  }

  /* 🔸 Botón naranja con ícono blanco */
  .compact-table .btn-warning {
    background-color: #ff9800;
    border-color: #ff9800;
    color: #fff;
  }
  .compact-table .btn-warning:hover {
    background-color: #e68900;
    border-color: #e68900;
  }
</style>
