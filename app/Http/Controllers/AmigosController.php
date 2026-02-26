<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AmigosController extends Controller
{
    /**
     * Muestra la lista de amigos y solicitudes pendientes.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Amigos ya aceptados
        $amigos = $user->amigos()->get();

        // 2. Solicitudes que HE RECIBIDO y están esperando mi respuesta
        $solicitudesRecibidas = $user->friendRequestsReceived()->get();

        // 3. Solicitudes que YO HE ENVIADO y aún no han aceptado
        $solicitudesEnviadas = $user->friendRequestsSent()
            ->wherePivot('status', 'pendiente')
            ->get();

        return view('pagina.amigos', compact('amigos', 'solicitudesRecibidas', 'solicitudesEnviadas'));
    }

    /**
     * Envía una solicitud de amistad.
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();

        // No puedes agregarte a ti mismo
        if ($user->id == $id) {
            return $this->responseHandler(false, 'No puedes enviarte una solicitud a ti mismo.');
        }

        // Verificar si ya existe alguna relación (cualquier estado)
        $existe = DB::table('amigos')
            ->where(function($q) use ($user, $id) {
                $q->where('user_id', $user->id)->where('amigo_id', $id);
            })
            ->orWhere(function($q) use ($user, $id) {
                $q->where('user_id', $id)->where('amigo_id', $user->id);
            })
            ->exists();

        if ($existe) {
            return $this->responseHandler(false, 'Ya existe una solicitud o amistad con este usuario.');
        }

        // Crear la solicitud (user_id soy yo, amigo_id es el destino)
        $user->friendRequestsSent()->attach($id, ['status' => 'pendiente']);

        return $this->responseHandler(true, '¡Solicitud de amistad enviada correctamente!');
    }

    /**
     * Acepta una solicitud de amistad recibida.
     */
    public function accept($id)
    {
        $user = Auth::user();

        // Buscamos la fila donde el destino era YO y el origen era el otro usuario
        $solicitud = DB::table('amigos')
            ->where('amigo_id', $user->id)
            ->where('user_id', $id)
            ->where('status', 'pendiente');

        if (!$solicitud->exists()) {
            return $this->responseHandler(false, 'La solicitud no existe o ya fue procesada.');
        }

        // 1. Actualizamos la solicitud a aceptada
        $solicitud->update(['status' => 'aceptada']);

        // 2. IMPORTANTE: Creamos la fila inversa para que la amistad sea bidireccional
        // Así ambos aparecen en la lista de 'amigos' del otro automáticamente.
        DB::table('amigos')->insert([
            'user_id' => $user->id,
            'amigo_id' => $id,
            'status' => 'aceptada',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $this->responseHandler(true, '¡Ahora sois amigos!');
    }

    /**
     * Rechaza una solicitud de amistad.
     */
    public function reject($id)
    {
        $user = Auth::user();

        $borrado = DB::table('amigos')
            ->where('amigo_id', $user->id)
            ->where('user_id', $id)
            ->where('status', 'pendiente')
            ->delete();

        return $borrado 
            ? $this->responseHandler(true, 'Solicitud rechazada.')
            : $this->responseHandler(false, 'No se pudo encontrar la solicitud.');
    }

    /**
     * Elimina a un amigo de la lista.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        // Borramos en ambas direcciones para romper el vínculo totalmente
        DB::table('amigos')
            ->where(function($q) use ($user, $id) {
                $q->where('user_id', $user->id)->where('amigo_id', $id);
            })
            ->orWhere(function($q) use ($user, $id) {
                $q->where('user_id', $id)->where('amigo_id', $user->id);
            })
            ->delete();

        return $this->responseHandler(true, 'Amigo eliminado de tu lista.');
    }

    /**
     * Función auxiliar para decidir si responder con JSON (AJAX) o redirección (Formulario).
     */
    private function responseHandler($success, $message)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => $success,
                'message' => $message
            ], $success ? 200 : 400);
        }

        return back()->with($success ? 'success' : 'error', $message);
    }
}