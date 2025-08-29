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
      <div class="card-body table-responsive p-0" style="height: 20rem;">
        <table class="table table-sm table-head-fixed text-nowrap table-hover table-bordered table-striped">
          <thead class="small"> <!-- encabezados más chicos -->
            {{ $thead }}
          </thead>
          <tbody class="small"> <!-- cuerpo más chico -->
            {{ $tbody }}
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
<!-- /.row -->
