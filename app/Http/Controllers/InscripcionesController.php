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

public function inscritas()
{
    $user = auth()->user();
    if (!$user) return response()->json([]);

    $actividades = $user->actividades->map(function($act) {
        return [
            'fecha' => $act->fecha,
            'nombre' => $act->nombre,
            'color' => $this->generarColor($act->nombre),
            'fechaFormateada' => \Carbon\Carbon::parse($act->fecha)->format('d/m/Y')
        ];
    });

    return response()->json($actividades);
}

private function generarColor($str) {
    $colores = ['#bc6a50', '#2d6a4f', '#1d3557', '#e63946', '#ffb703', '#8338ec', '#0077b6'];
    $hash = 0; 
    for ($i = 0; $i < strlen($str); $i++) {
        $hash = ord($str[$i]) + (($hash << 5) - $hash);
    }
    return $colores[abs($hash) % count($colores)];
}
}
