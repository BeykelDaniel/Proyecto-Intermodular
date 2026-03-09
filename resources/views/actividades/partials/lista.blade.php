@php $misIds = auth()->check() ? auth()->user()->actividades->pluck('id')->toArray() : []; @endphp

@foreach($actividades as $a)
    @if($a->cupos > 0 && !isset($a->hidden))
    <div class="actividad-item p-5 rounded-xl border-2 border-gray-100 flex flex-col hover:border-[#82aeb4] transition-all bg-white shadow-md">
        
        @if($a->imagen)
        <div class="h-40 w-full overflow-hidden rounded-lg mb-4">
            <img src="{{ asset($a->imagen) }}" alt="{{ $a->nombre }}" class="w-full h-full object-cover">
        </div>
        @endif

        <div class="flex justify-between items-start mb-3">
            <span class="font-black text-gray-900 text-xl uppercase leading-tight">{{ $a->nombre }}</span>
            <span class="text-[#bc6a50] font-black text-xl">{{ $a->precio }}€</span>
        </div>

        <div class="flex flex-wrap items-center gap-x-4 text-xs font-bold mb-5 uppercase tracking-widest text-gray-500 italic">
            <span><i class="bi bi-geo-fill text-[#bc6a50]"></i> {{ $a->lugar }}</span>
            <span class="text-gray-300">|</span>
            <span>{{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}</span>
        </div>

        <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-50">
            <span class="text-sm text-blue-600 font-black uppercase">Cupos: {{ $a->cupos }}</span>
            
            @if(in_array($a->id, $misIds))
                <button class="bg-gray-100 text-gray-400 px-5 py-2 rounded-lg font-black text-xs uppercase cursor-default border-none shadow-none" disabled>
                    ¡Apuntado!
                </button>
            @else
                <button 
                    data-actividad='@json($a)'
                    class="btn-ver-mas-act bg-[#82aeb4] text-white px-6 py-2.5 rounded-lg font-black text-xs uppercase hover:bg-[#32424D] transition-colors shadow-lg">
                    Ver más
                </button>
            @endif
        </div>
    </div>
    @endif
@endforeach