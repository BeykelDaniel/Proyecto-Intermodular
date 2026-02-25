<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForoController extends Controller
{
    public function index()
    {
        $actividades = auth()->user()->actividades()->withCount('posts')->get();
        return view('pagina.foro', compact('actividades'));
    }

    public function show($id)
    {
        $user = auth()->user();
        if (!$user->actividades()->where('actividades_id', $id)->exists()) {
            return redirect()->route('pagina.foro')->with('error', 'No estás inscrito en esta actividad.');
        }
        
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
    public function getNewMessages(Request $request, $id)
    {
        $lastId = $request->query('last_id', 0);
        $posts = Post::with('user')
            ->where('actividades_id', $id)
            ->where('id', '>', $lastId)
            ->get();

        return response()->json($posts);
    }
}
