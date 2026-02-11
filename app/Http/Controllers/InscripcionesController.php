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
}
