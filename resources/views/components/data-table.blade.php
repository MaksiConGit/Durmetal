<style>
  .table-fixed-header {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}

.table-fixed-header thead th,
.table-fixed-header tfoot td {
  position: sticky;
  background: #fff;
  z-index: 2;
}

.table-fixed-header thead th {
  top: 0;
  border-bottom: 2px solid #dee2e6;
}

.table-fixed-header tfoot td {
  bottom: 0;
  border-top: 2px solid #dee2e6;
}

.scroll-table-body {
  max-height: 500px; /* Ajustá según necesites */
  overflow-y: auto;
  overflow-x: auto;
}

.scroll-table-wrapper {
  overflow-x: auto;
}
</style>


<div class="card">
  <div class="card-header">
    <div class="d-flex align-items-center justify-content-between">
      <h4 class="card-title mb-0">{{ $table_title }}</h4>
      <div class="d-flex">
        <a href="{{ $export_route }}" class="btn btn-primary btn-round me-2">
          <i class="fa fa-download"></i> Exportar
        </a>
        <a href="{{ $create_route }}" class="btn btn-primary btn-round">
          <i class="fa fa-plus"></i> {{ $add_text }}
        </a>
      </div>
    </div>
  </div>

  <div class="scroll-table-wrapper">
    <div class="scroll-table-body">
      <table class="table table-striped table-hover table-condensed table-fixed-header">
        <thead>
          {{ $head_tr }}
        </thead>
        <tbody>
          {{ $body_tr }}
        </tbody>
      </table>
    </div>
  </div>
</div>
