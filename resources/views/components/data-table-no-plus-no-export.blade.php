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
    {{-- <div class="container-fluid"> --}}
    {{-- <div class="page-inner"> --}}
      {{-- <div class="col-md-12">
        <div class="card">
          <div class="card-header">
          <div class="table-responsive table-container"> --}}
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
          {{-- </div>
        </div>
      </div>
    </div> --}}
  {{-- </div> --}}

  
