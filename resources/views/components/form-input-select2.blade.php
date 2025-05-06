<style>
  .select2-container--default .select2-selection--single {
    height: 3rem !important;
    padding: 0.5rem 1rem !important;
    border: 2px solid rgba(206, 212, 218, 0.7) !important;
    border-radius: 0.375rem;
    line-height: 1.5;
    box-sizing: border-box;
    font-size: 1rem;
    display: flex;
    align-items: center;
  }

  .select2-container {
    width: 100% !important;
    display: inline-block;
    box-sizing: border-box;
  }

  .select2-container--default {
    width: auto !important;
    min-width: 100%;
    transform: none !important;
  }
</style>

<div class="form-group">
  <label for="{{$name}}">{{$label}}</label>
  <select class="js-example-basic-single form-select form-control"
    id="{{$name}}"
    name="{{$name}}"
  >
  </select>
</div>

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $('#IdLocalidad').select2({
      ajax: {
        url: '{{ route("cities.search") }}',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term || '',
            page: params.page || 1
          };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;

          return {
            results: data.items,
            pagination: {
              more: data.more
            }
          };
        },
        cache: true
      },
      placeholder: 'Selecciona una ciudad',
      minimumInputLength: 0
    });

  </script>
@endsection
