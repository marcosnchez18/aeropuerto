<x-app-layout>
    <div class="relative overflow-x-auto w-3/4 mx-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">
                        Usuario
                    </th>
                    <th class="px-6 py-3">
                        Código de reserva
                    </th>
                    <th class="px-6 py-3">
                        Origen
                    </th>
                    <th class="px-6 py-3">
                        Destino
                    </th>
                    <th class="px-6 py-3">
                        Compañía
                    </th>
                    <th class="px-6 py-3">
                        Precio
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $reserva->user->email }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $reserva->id }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $reserva->vuelo->origen->nombre }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{$reserva->vuelo->destino->nombre}}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{$reserva->vuelo->compania->nombre}}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{$reserva->vuelo->precio}}
                    </td>

                </tr>
            </tbody>
        </table>
        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('reservas.index') }}">
                <x-secondary-button class="ms-4">
                    Volver
                    </x-primary-button>
            </a>
        </div>
    </div>
</x-app-layout>
