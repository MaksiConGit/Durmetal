<style>
  .table-condensed td,
  .table-condensed th {
    padding: 0.6rem 0.75rem;
    font-size: 1rem;
    white-space: nowrap;
    min-width: 120px;
  }

  .table-fixed-header {
    width: max-content;
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

  .scroll-table-wrapper {
    width: 100%;
    overflow-x: auto;
  }

  .scroll-table-body {
    max-height: 500px; /* Si querés scroll vertical, si no, podés sacarlo */
    overflow-y: auto;
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

    <div class="scroll-table-wrapper">
      <div class="scroll-table-body">
        <table id="add-row" class="display table table-striped table-hover table-condensed table-fixed-header">
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

    <div class="card-action">
      {{ $buttons ?? '' }}
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $("#add-row").DataTable({
      pageLength: 5,
      scrollX: true
    });

    var action = '<td> <div class="form-button-action"> <button type="button" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></button> <button type="button" class="btn btn-link btn-danger"><i class="fa fa-times"></i></button> </div> </td>';

    $("#addRowButton").click(function () {
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
  });
</script>
