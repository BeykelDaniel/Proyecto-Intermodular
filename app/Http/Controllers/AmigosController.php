<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AmigosController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $amigos = $user->amigos()->get();
        return view('pagina.amigos', compact('amigos'));
    }

    public function store(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->id == $id) {
            return response()->json(['success' => false, 'message' => 'No puedes ser tu propio amigo.'], 400);
        }

        // Verificar si ya son amigos o hay solicitud pendiente
        $existe = \DB::table('amigos')
            ->where(function($q) use ($user, $id) {
                $q->where('user_id', $user->id)->where('amigo_id', $id);
            })
            ->orWhere(function($q) use ($user, $id) {
                $q->where('user_id', $id)->where('amigo_id', $user->id);
            })
            ->first();

        if ($existe) {
            return response()->json(['success' => false, 'message' => 'Ya existe una relación o solicitud.'], 400);
        }

        // Crear solicitud (solo en un sentido)
        $user->friendRequestsSent()->attach($id, ['status' => 'pendiente']);

        return response()->json([
            'success' => true,
            'message' => "¡Solicitud de amistad enviada!"
        ]);
    }

    public function accept($id)
    {
        $user = Auth::user();
        // Buscar la solicitud donde yo soy el amigo_id y el status es pendiente
        $solicitud = \DB::table('amigos')
            ->where('amigo_id', $user->id)
            ->where('user_id', $id)
            ->where('status', 'pendiente')
            ->update(['status' => 'aceptada']);

        if ($solicitud) {
            // Para que sea bidireccional en la lógica de relación (ya que Laravel usa user_id -> amigo_id)
            // Agregamos la fila inversa para que ambos se vean como amigos
            $user->amigos()->attach($id, ['status' => 'aceptada']);
            
            return response()->json(['success' => true, 'message' => 'Solicitud aceptada.']);
        }

        return response()->json(['success' => false, 'message' => 'No se encontró la solicitud.'], 404);
    }

    public function reject($id)
    {
        $user = Auth::user();
        $borrado = \DB::table('amigos')
            ->where('amigo_id', $user->id)
            ->where('user_id', $id)
            ->where('status', 'pendiente')
            ->delete();

        if ($borrado) {
            return response()->json(['success' => true, 'message' => 'Solicitud rechazada.']);
        }

        return response()->json(['success' => false, 'message' => 'No se encontró la solicitud.'], 404);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        // Borrar ambas direcciones
        \DB::table('amigos')
            ->where(function($q) use ($user, $id) {
                $q->where('user_id', $user->id)->where('amigo_id', $id);
            })
            ->orWhere(function($q) use ($user, $id) {
                $q->where('user_id', $id)->where('amigo_id', $user->id);
            })
            ->delete();

        return response()->json(['success' => true, 'message' => 'Amigo eliminado.']);
    }
}