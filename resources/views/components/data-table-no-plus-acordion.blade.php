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

  /* Expandible */
  .expandable-body {
    display: none;
  }

  tr[data-widget="expandable-table"][aria-expanded="true"] + .expandable-body {
    display: table-row;
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
        <tbody>
          {{ $body_tr }}
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $("#add-row").DataTable({
      pageLength: 5,
      scrollX: true
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

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('tr[data-widget="expandable-table"]').forEach(row => {
      row.addEventListener('click', () => {
        const isExpanded = row.getAttribute('aria-expanded') === 'true';
        row.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
      });
    });
  });
</script>
