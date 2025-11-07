{{-- <div class="row">
  <div class="col-12">
      @if(!empty($filtros))
          <div class="card-header">
              {{ $filtros }}
          </div>
      @endif
    <div class="card">
      <div class="card-body p-0">
        <table class="table table-hover table-sm" style="height: 26rem;">
          <thead>
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
</div> --}}



@if(!empty($filtros))
    <div class="card-header">
        {{ $filtros }}
    </div>
@endif

<div style="max-height: 26rem; overflow-y: auto;">
  <table class="table table-head-fixed text-nowrap table-hover table-bordered table-sm mb-0">
    <thead class="thead-light">
      {{ $thead }}
    </thead>
    <tbody>
      {{ $tbody }}
    </tbody>
  </table>
</div>
