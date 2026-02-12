<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Administrar Álbum Multimedia') }}
            </h2>
            {{-- Botón para ir al álbum público --}}
            <a href="{{ route('pagina.album') }}"
                class="bg-[#bc6a50] text-white px-4 py-2 rounded-lg text-sm font-bold uppercase shadow-sm hover:bg-[#32424D] transition-all">
                Ver Álbum Público
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensajes de Estado --}}
            @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm"
                role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
            @endif

            @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm"
                role="alert">
                <span class="block sm:inline font-medium">{{ session('error') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Miniatura</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Subida</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($fotos as $foto)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    {{-- Miniatura con soporte para Video --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="h-16 w-16 rounded-lg overflow-hidden border border-gray-100 bg-gray-50">
                                            @if($foto->tipo == 'foto')
                                            <img src="{{ asset($foto->url) }}" class="h-full w-full object-cover">
                                            @else
                                            <video src="{{ asset($foto->url) }}" class="h-full w-full object-cover"
                                                muted></video>
                                            @endif
                                        </div>
                                    </td>
                                    {{-- Etiqueta de Tipo --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $foto->tipo == 'foto' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ ucfirst($foto->tipo) }}
                                        </span>
                                    </td>
                                    {{-- Fecha formateada --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($foto->created_at)->format('d/m/Y H:i') }}
                                    </td>
                                    {{-- Botones de Acción --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-3">
                                            {{-- Ver Original --}}
                                            <a href="{{ asset($foto->url) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900" title="Ver original">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            {{-- Eliminar --}}
                                            <form action="{{ route('fotos.destroy', $foto->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('¿Estás totalmente seguro? El archivo físico también se borrará.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">No hay archivos
                                        multimedia registrados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación (Asegúrate de usar paginate() en el controlador) --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>