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
