<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividades;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Fundamental para manejar el tiempo

class ActividadesController extends Controller
{
    /**
     * Vista de administración (Tabla de gestión)
     * Muestra todas las actividades para que el admin pueda editarlas o borrarlas.
     */
    public function index(Request $request)
    {
        if (Auth::user()->email !== 'cabrerajosedaniel89@gmail.com') {
            return redirect()->route('pagina.inicio')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // Ordenamos por fecha para que el admin vea lo más próximo arriba
        $actividades = Actividades::orderBy('fecha', 'asc')->paginate(10);

        if ($request->ajax()) {
            return view('actividades.partials.lista', compact('actividades'))->render();
        }

        return view('actividades.index', compact('actividades'));
    }

    /**
     * Vista principal del usuario (Página de Inicio)
     * Filtra para que NO aparezcan actividades que ya han pasado.
     */
    public function indexPrincipal(Request $request)
    {
        // Obtenemos la fecha de hoy (formato YYYY-MM-DD)
        $hoy = Carbon::today()->toDateString();

        // Filtramos: Solo actividades cuya fecha sea hoy o en el futuro
        $actividades = Actividades::where('fecha', '>=', $hoy)
            ->orderBy('fecha', 'asc')
            ->paginate(4);

        // Actividades del usuario logueado (para la sección "Mis Álbumes")
        $mis_actividades = [];
        if (Auth::check()) {
            // Cargamos las actividades del usuario con sus fotos (media)
            $mis_actividades = Auth::user()->actividades()->with('media')->get();
        }

        if ($request->ajax()) {
            // Útil para sistemas de scroll infinito o botones "Cargar más"
            return view('actividades.partials.lista', compact('actividades'))->render();
        }

        return view('pagina.inicio', compact('actividades', 'mis_actividades'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('actividades.create', [
            'actividad' => new Actividades(),
            'oper' => 'create'
        ]);
    }

    /**
     * Guardar nueva actividad
     */
    public function store(Request $request)
    {
        $isAdmin = Auth::user()->email == 'cabrerajosedaniel89@gmail.com';
        
        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'descripcion'      => 'required|string',
            'fecha'            => 'required|date',
            'hora'             => 'required|string',
            'lugar'            => 'required|string',
            'precio'           => $isAdmin ? 'required|numeric' : 'nullable|numeric',
            'cupos'            => $isAdmin ? 'required|numeric' : 'nullable|numeric',
            'imagen'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!$isAdmin) {
            $validated['precio'] = $validated['precio'] ?? 0;
            $validated['cupos'] = $validated['cupos'] ?? 50;
        }

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('actividades', 'public');
            $validated['imagen'] = 'storage/' . $path;
        } else {
            // Imagen genérica basada en palabras clave + LOCK único para evitar repetidas
            $keyword = urlencode($request->nombre);
            $seed = rand(1, 9999);
            $validated['imagen'] = "https://loremflickr.com/800/600/{$keyword}/all?lock={$seed}";
        }

        Actividades::create($validated);

        // Regresamos con mensaje de éxito
        return back()->with('success', '¡La actividad se ha creado con éxito!');
    }

    /**
     * Mostrar una actividad específica (Modo lectura)
     */
    public function show(Actividades $actividad)
    {
        return view('actividades.create', ['actividad' => $actividad, 'oper' => 'show']);
    }

    /**
     * Formulario de edición
     */
    public function edit(Actividades $actividad)
    {
        return view('actividades.create', ['actividad' => $actividad, 'oper' => 'edit']);
    }

    /**
     * Actualizar actividad existente
     */
    public function update(Request $request, Actividades $actividad)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha'       => 'required|date',
            'hora'        => 'required|string',
            'lugar'       => 'required|string',
            'precio'      => 'required|numeric',
            'cupos'       => 'required|numeric',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('actividades', 'public');
            $validated['imagen'] = 'storage/' . $path;
        } elseif (empty($actividad->imagen) || str_contains($actividad->imagen, 'loremflickr.com')) {
            // Si no tiene o es de la API, la regeneramos por si ha cambiado el nombre
            $keyword = urlencode($request->nombre);
            $seed = rand(1, 9999);
            $validated['imagen'] = "https://loremflickr.com/800/600/{$keyword}/all?lock={$seed}";
        }

        $actividad->update($validated);

        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada correctamente.');
    }

    /**
     * Eliminar actividad
     */
    public function destroy(Actividades $actividad)
    {
        // Esto también debería eliminar las relaciones en la tabla pivote si usas onDelete('cascade')
        $actividad->delete();
        
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada correctamente.');
    }

    /**
     * Método para inscribir al usuario en una actividad (Muchos a Muchos)
     */
    public function inscribir(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Debes iniciar sesión'], 401);
        }

        $actividad = Actividades::findOrFail($id);
        $user = Auth::user();

        // Evitar duplicados en la tabla pivote 'actividad_user'
        if (!$user->actividades()->where('actividad_id', $id)->exists()) {
            $user->actividades()->attach($id);
            return response()->json([
                'success' => true, 
                'message' => '¡Te has inscrito correctamente!'
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'Ya estás inscrito en esta actividad'
        ]);
    }
}