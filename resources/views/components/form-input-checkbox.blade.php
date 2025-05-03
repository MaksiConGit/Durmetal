<div class="col-auto">
  <label for="">{{$label}}</label>
  <label class="colorinput">
    <input
      name="{{$name}}"
      type="checkbox"
      id="{{$name}}"
      value="{{$value}}"
      class="colorinput-input" 
      {{$checked}}
    />
    <span class="colorinput-color bg-{{$color}}"></span>
  </label>
</div>

{{-- <input type="checkbox" name="is_active" id="is_active" value="1" checked> --}}
