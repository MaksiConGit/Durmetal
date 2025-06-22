<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input
      type="text"
      {{$livewire}}
      class="form-control form-control {{$error}}"
      id="{{$name}}"
      name="{{$name}}"
      value="{{$value}}"
      placeholder="{{$placeholder}}" 
    />
      <small class="form-text text-muted"
    >{{$message}}</small
  >
  </div>
