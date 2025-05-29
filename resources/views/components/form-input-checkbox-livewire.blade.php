<style>
  .form-group.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .form-group.checkbox-group label {
    display: inline-block;
  }

  .form-group.checkbox-group .colorinput {
    display: inline-block;
    vertical-align: middle;
  }
</style>

<div class="form-group checkbox-group">
  <label for="{{$name}}" class="mr-2">{{ $label }}</label>
  <label class="colorinput">
    <input
      name="{{$name}}"
      type="checkbox"
      id="{{$name}}"
      value="{{$value}}"
      class="colorinput-input"
      {{ $checked }}
      {{$livewire}}
    />
    <span class="colorinput-color bg-{{$color}}"></span>
  </label>
</div>
