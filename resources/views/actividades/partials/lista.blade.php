@php $misIds = auth()->check() ? auth()->user()->actividades->pluck('id')->toArray() : []; @endphp

@foreach($actividades as $a)
{{-- Filtro de cupos y ocultos --}}
@if($a->cupos > 0 && !isset($a->hidden))
<div
    class="p-4 rounded-xl border border-gray-100 flex flex-col hover:border-[#82aeb4] transition-all bg-white shadow-sm">
    @if($a->imagen)
    <div class="h-32 w-full overflow-hidden rounded-lg mb-3">
        <img src="{{ asset($a->imagen) }}" alt="{{ $a->nombre }}" class="w-full h-full object-cover">
    </div>
    @endif
    <div class="flex justify-between items-start mb-2">
        <span class="font-black text-gray-800 text-lg uppercase">{{ $a->nombre }}</span>
        <span class="text-[#bc6a50] font-bold">{{ $a->precio }}€</span>
    </div>
    <div class="flex flex-wrap items-center gap-x-3 text-xs font-bold mb-4 uppercase tracking-wide">
        <span class="text-[#3b4d57] font-bold text-sm"><i class="bi bi-geo-fill text-[#bc6a50]"></i> {{ $a->lugar
            }}</span>
        <span class="text-[#3b4d57] font-bold text-sm">|</span>
        <span class="text-[#3b4d57] font-bold text-sm">{{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}</span>
        <span class="text-[#3b4d57] font-bold text-sm">|</span>
        <span class="text-[#3b4d57] font-bold text-sm">{{ \Carbon\Carbon::parse($a->hora)->format('H:i') }}h</span>
    </div>
    <div class="mt-2 mb-2 flex justify-between items-center font-bold">
        <span class="text-[15px] text-blue-500 font-bold uppercase">Cupos: {{ $a->cupos }}</span>
        @if(in_array($a->id, $misIds))
        <button class="bg-gray-300 text-black px-4 py-1.5 rounded-lg font-black text-xs uppercase cursor-not-allowed"
            disabled>¡Apuntado!</button>
        @else
        <button id="btn-{{ $a->id }}" onclick="abrirModal({{ json_encode($a) }})"
            class="bg-[#82aeb4] text-white px-4 py-1.5 rounded-lg font-black text-xs uppercase hover:bg-[#32424D] transition-colors">Ver
            más</button>
        @endif
    </div>
</div>
@endif
@endforeach