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
        <table class="table table-head-fixed text-nowrap table-hover table-bordered table-striped">
          <thead>
            {{ $thead }}
          </thead>
          <tbody>
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
