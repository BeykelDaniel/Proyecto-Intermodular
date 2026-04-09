<?php

namespace App\Http\Controllers;
use App\Models\Actividades;
use Illuminate\Http\Request;

class InscripcionesController extends Controller
{
    public function inscribir(Request $request, $actividadId) {
    $user = auth()->user();
    $actividad = Actividades::findOrFail($actividadId);

    // 1. Evitar duplicados: Comprobar si ya está inscrito
    if ($user->actividades()->where('actividades_id', $actividadId)->exists()) {
        return response()->json(['error' => 'Ya estás inscrito'], 422);
    }

    // 2. Descuento de plazas: Comprobar si hay cupos
    if ($actividad->cupos <= 0) {
        return response()->json(['error' => 'No quedan plazas'], 422);
    }

    // 3. Guardar y Restar
    $user->actividades()->attach($actividadId);
    $actividad->decrement('cupos'); // Resta 1 automáticamente

    return response()->json(['success' => 'Inscrito correctamente']);
}

// En InscripcionesController.php
public function inscritas()
{
    $user = auth()->user();
    if (!$user) return response()->json([]);

    // Usamos get() para obtener los datos reales antes del map
    $actividades = $user->actividades()->get()->map(function($act) {
        return [
            'fecha' => $act->fecha,
            'nombre' => $act->nombre,
            'color' => \App\Models\Actividades::generarColor($act->nombre),
            // Validación de fecha para evitar el Error 500
            'fechaFormateada' => $act->fecha ? \Carbon\Carbon::parse($act->fecha)->format('d/m/Y') : 'Pendiente'
        ];
    });

    return response()->json($actividades);
}

public function mis_inscripciones(Request $request)
{
    $user = auth()->user();
    if (!$user) return redirect()->route('pagina.login_usuarios');

    $actividades = $user->actividades()->get()->map(function($act) {
        return [
            'fecha' => $act->fecha,
            'nombre' => $act->nombre,
            'descripcion' => $act->descripcion,
            'color' => \App\Models\Actividades::generarColor($act->nombre),
            'fechaFormateada' => $act->fecha ? \Carbon\Carbon::parse($act->fecha)->format('d/m/Y') : 'Pendiente',
            'hora' => $act->hora,
            'lugar' => $act->lugar
        ];
    });

    // Ordenar actividades por fecha
    $actividades = $actividades->sortBy('fecha');

    return view('actividades.mis_inscripciones', compact('actividades'));
}
}
