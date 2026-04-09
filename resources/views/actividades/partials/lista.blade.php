@php $misIds = auth()->check() ? auth()->user()->actividades->pluck('id')->toArray() : []; @endphp

@foreach($actividades as $a)
    @if($a->cupos > 0 && !isset($a->hidden))
    <div class="p-4 rounded-xl border border-gray-100 flex flex-col hover:border-[#82aeb4] transition-all bg-white shadow-sm">
        
        @if($a->imagen)
        <div class="h-32 w-full overflow-hidden rounded-lg mb-3">
            <img src="{{ asset($a->imagen) }}" alt="{{ $a->nombre }}" class="w-full h-full object-cover">
        </div>
        @endif

        <div class="flex justify-between items-start mb-2">
            <span class="font-black text-gray-800 text-lg uppercase leading-tight">{{ $a->nombre }}</span>
            <span class="text-[#bc6a50] font-black">{{ $a->precio }}€</span>
        </div>

        <div class="flex flex-wrap items-center gap-x-3 text-[10px] font-bold mb-4 uppercase tracking-widest text-gray-400 italic">
            <span><i class="bi bi-geo-fill text-[#bc6a50]"></i> {{ $a->lugar }}</span>
            <span>|</span>
            <span>{{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}</span>
        </div>

        <div class="mt-auto flex justify-between items-center">
            <span class="text-[12px] text-blue-500 font-black uppercase">Cupos: {{ $a->cupos }}</span>
            
            @if(in_array($a->id, $misIds))
                <button class="bg-gray-100 text-gray-400 px-4 py-1.5 rounded-lg font-black text-[10px] uppercase cursor-default" disabled>
                    ¡Apuntado!
                </button>
            @else
                <button 
                    data-actividad='@json($a)'
                    class="btn-ver-mas-act bg-[#82aeb4] text-white px-4 py-1.5 rounded-lg font-black text-[10px] uppercase hover:bg-[#32424D] transition-colors shadow-md">
                    Ver más
                </button>
            @endif
        </div>
    </div>
    @endif
@endforeach