<div class="row">
  <div class="col-12">
    <div class="card">

      @if(!empty($filtros))
        <div class="card-header">
          {{ $filtros }}
        </div>
      @endif

      <div class="card-body p-0">

        <!-- 🔹 CONTENEDOR CON SCROLL -->
        <div class="table-container">

          <table class="table table-hover table-bordered table-striped table-sm compact-table">

            @if(!empty($thead))
              <thead class="thead-fixed">
                {{ $thead }}
              </thead>
            @endif

            <tbody>
              {{ $tbody }}
            </tbody>

          </table>

        </div>

      </div>

    </div>
  </div>
</div>

<style>
  /* 🔸 Contenedor con scroll para limitar altura */
  .table-container {
    max-height: 160px; /* ≈ 3 filas */
    overflow-y: auto;
    display: block;  /* esencial */
  }

  /* 🔸 Ajustar tabla al sistema de scroll */
  .table-container table {
    width: 100%;
    border-collapse: collapse;
    display: table;
  }

  /* 🔸 Fix para mantener los anchos del header */
  .table-container thead.thead-fixed {
    position: sticky;
    top: 0;
    background: #f4f6f9;
    z-index: 10;
  }

  /* 🔸 Compactar filas */
  .compact-table td,
  .compact-table th {
    padding: 0.25rem 0.4rem !important;
    vertical-align: middle;
    white-space: nowrap;
  }

  /* Inputs y botones mini */
  .compact-table input,
  .compact-table select,
  .compact-table button {
    height: 24px !important;
    font-size: 0.75rem !important;
    padding: 0 0.3rem !important;
  }

  .compact-table .btn i {
    font-size: 0.8rem;
  }
</style>
