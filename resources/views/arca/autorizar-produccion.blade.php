<form method="POST" action="{{ route('afip.autorizar-produccion') }}">
    @csrf

    <div class="mb-3">
        <label for="cuit">CUIT</label>
        <input
            type="text"
            id="cuit"
            name="cuit"
            class="form-control"
            value="{{ old('cuit') }}"
            placeholder="20111111112"
            required
        >

        @error('cuit')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="username">Usuario AFIP</label>
        <input
            type="text"
            id="username"
            name="username"
            class="form-control"
            value="{{ old('username') }}"
            required
        >

        @error('username')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password">Contraseña AFIP</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            required
        >

        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="service">Servicio</label>
        <input
            type="text"
            id="service"
            name="service"
            class="form-control"
            value="{{ old('service', 'wsfe') }}"
            required
        >

        @error('service')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    @error('afip')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button type="submit" class="btn btn-primary">
        Autorizar producción
    </button>
</form>