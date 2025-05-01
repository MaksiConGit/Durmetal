<div class="col-auto">
    <label for="">{{$label}}</label>
    <label class="colorinput">
      <input
        name="{{$name}}"
        type="checkbox"
        value="{{$value}}"
        class="colorinput-input"
        {{$checked}}
      />
      <span class="colorinput-color bg-{{$color}}"></span>
    </label>
  </div>