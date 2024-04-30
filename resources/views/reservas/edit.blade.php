<x-app-layout>
    <div class="w-1/2 mx-auto">
        <form method="POST"
            action="{{ route('reservas.update', ['reserva' => $reserva]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')



            <!-- Vuelos -->
            <div class="mt-4">
                <x-input-label for="vuelo_id" :value="'Vuelos disponibles'" />
                <select id="vuelo_id"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                    name="vuelo_id">
                    @foreach ($vuelos as $vuelo)
                        <option value="{{ $vuelo->id }}"
                            {{ old('vuelo_id') == $vuelo->id ? 'selected' : '' }}
                            >
                            Vuelo {{ $vuelo->origen->nombre }} - {{ $vuelo->destino->nombre }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('vuelo_id')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('reservas.index') }}">
                    <x-secondary-button class="ms-4">
                        Volver
                        </x-primary-button>
                </a>
                <x-primary-button class="ms-4">
                    Editar
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
