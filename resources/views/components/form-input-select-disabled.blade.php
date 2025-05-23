<div class="form-group">
  <label for="{{$name}}"
    >{{$label}}</label
  >
  <select
    class="form-select form-control {{$error}}"
    id="{{$name}}"
    name="{{$name}}"
    disabled
  >
  {{$option}}
  </select>
  <small class="form-text text-muted"
  >{{$message}}</small>
</div>