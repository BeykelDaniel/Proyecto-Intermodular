<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MensajePrivado;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Mostrar el chat con un amigo específico
     */
    public function show($amigo_id)
    {
        $amigo = User::findOrFail($amigo_id);
        
        // Verificar que son amigos (opcional pero recomendado)
        $sonAmigos = \DB::table('amigos')
            ->where(function($q) use ($amigo_id) {
                $q->where('user_id', Auth::id())->where('amigo_id', $amigo_id);
            })
            ->orWhere(function($q) use ($amigo_id) {
                $q->where('user_id', $amigo_id)->where('amigo_id', Auth::id());
            })
            ->where('status', 'aceptada')
            ->exists();

        if (!$sonAmigos) {
            return redirect()->route('pagina.amigos')->with('error', 'Solo puedes chatear con tus amigos.');
        }

        $mensajes = MensajePrivado::where(function($q) use ($amigo_id) {
                $q->where('user_id', Auth::id())->where('amigo_id', $amigo_id);
            })
            ->orWhere(function($q) use ($amigo_id) {
                $q->where('user_id', $amigo_id)->where('amigo_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Marcar mensajes como leídos
        MensajePrivado::where('amigo_id', Auth::id())
            ->where('user_id', $amigo_id)
            ->where('leido', false)
            ->update(['leido' => true]);

        return view('pagina.chat_privado', compact('amigo', 'mensajes'));
    }

    /**
     * Enviar un mensaje
     */
    public function store(Request $request, $amigo_id)
    {
        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        MensajePrivado::create([
            'user_id' => Auth::id(),
            'amigo_id' => $amigo_id,
            'contenido' => $request->contenido,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    /**
     * Obtener nuevos mensajes (Polling AJAX)
     */
    public function getNuevos(Request $request, $amigo_id)
    {
        $lastId = $request->query('last_id', 0);
        
        $mensajes = MensajePrivado::with('user')
            ->where('id', '>', $lastId)
            ->where(function($q) use ($amigo_id) {
                $q->where('user_id', Auth::id())->where('amigo_id', $amigo_id);
            })
            ->orWhere(function($q) use ($amigo_id) {
                $q->where('user_id', $amigo_id)->where('amigo_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($mensajes);
    }
}
