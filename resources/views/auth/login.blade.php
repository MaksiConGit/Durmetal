<x-guest-layout>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Usuario -->
        <div>
            <x-input-label for="Usuario" :value="__('Usuario')" />

            <x-text-input 
                id="Usuario"
                class="block mt-1 w-full"
                type="text"
                name="Usuario"
                :value="old('Usuario')"
                required
                autofocus
                autocomplete="username" />

            <x-input-error 
                :messages="$errors->get('Usuario')" 
                class="mt-2" />
        </div>


        <!-- Contraseña -->
        <div class="mt-4">

            <x-input-label 
                for="Contraseña" 
                :value="__('Contraseña')" />

            <x-text-input 
                id="Contraseña"
                class="block mt-1 w-full"
                type="password"
                name="Contraseña"
                required
                autocomplete="current-password" />

            <x-input-error 
                :messages="$errors->get('Contraseña')" 
                class="mt-2" />

        </div>


        <!-- Recordar -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recuérdame') }}</span>
            </label>
        </div>


        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-3">
                {{ __('Loguearse') }}
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>