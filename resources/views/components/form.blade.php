<div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <form action="{{ $action }}" method="POST">
            @csrf
            {{$method}}
            <div class="card">
              <div class="card-header">
                <div class="card-title">{{ $card_title }}</div>
              </div>
              <div class="card-body">
                <div class="row">
                  {{ $inputs }}
                </div>
              </div>              
              <div class="card-action">
                {{ $buttons }}
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  