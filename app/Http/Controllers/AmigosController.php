<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AmigosController extends Controller
{
    public function index()
    {
        return view('amigos.index');
    }

    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $amigo = User::findOrFail($id);

        // Evitar auto-solicitudes o duplicados
        if ($user->id == $id || $user->amigos()->where('amigo_id', $id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Ya son amigos o es una solicitud propia.'], 400);
        }

        // Crear la relación (asumiendo que usas ManyToMany)
        $user->amigos()->attach($id);

        return response()->json([
            'success' => true,
            'message' => "¡Ahora sois amigos!"
        ]);
    }
}