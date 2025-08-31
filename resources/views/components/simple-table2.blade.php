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
      <div class="card-body table-responsive p-0" style="height: 26rem;">
        <table class="table table-head-fixed text-nowrap table-hover table-bordered table-striped table-sm">
          @if(!empty($thead))
            <thead>
              {{ $thead }}
            </thead>
          @endif
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
