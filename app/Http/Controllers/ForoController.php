<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForoController extends Controller
{
    public function show($id)
    {
        $actividad = Actividades::with('posts.user')->findOrFail($id);
        return view('pagina.foro', compact('actividad'));
    }

    public function post(Request $request, $id)
    {
        $request->validate([
            'contenido' => 'required|string',
        ]);

        Post::create([
            'actividades_id' => $id,
            'user_id' => Auth::id(),
            'contenido' => $request->contenido,
        ]);

        return back()->with('success', 'Mensaje publicado en el foro.');
    }
}
