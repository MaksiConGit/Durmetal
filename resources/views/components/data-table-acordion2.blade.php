<div class="row">
  <div class="col-12">
      @if(!empty($filtros))
          <div class="card-header">
              {{ $filtros }}
          </div>
      @endif
      <div class="card">
        <div class="card-body p-0" style="max-height: 15rem; overflow-y: auto;">
          <table class="table table-hover table-sm text-sm mb-0">
            <thead style="position: sticky; top: 0; background: white; z-index: 10;">
              {{ $thead }}
            </thead>
            <tbody>
              {{ $tbody }}
            </tbody>
          </table>
        </div>
      </div>
      
  </div>

  <style>
  tr[data-widget="expandable-table"][aria-expanded="true"] {
      background-color: rgba(0, 0, 0, 0.075);
  }
  </style>
</div>

