<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividades; // Asegúrate de que el modelo se llame así
use Illuminate\Support\Facades\Auth;

class ActividadesController extends Controller
{
    /**
     * Vista de administración (Tabla de gestión)
     */
    public function index(Request $request)
    {
        $actividades = Actividades::orderBy('fecha', 'asc')->paginate(10);

        if ($request->ajax()) {
            return view('actividades.partials.lista', compact('actividades'))->render();
        }

        return view('actividades.index', compact('actividades'));
    }

    /**
     * Vista principal del usuario (Inicio)
     */
    public function indexPrincipal(Request $request)
    {
        // Traemos las actividades ordenadas por fecha próxima
        $actividades = Actividades::orderBy('fecha', 'asc')->paginate(4);

        // También necesitamos las actividades en las que el usuario está inscrito para "Mis Álbumes"
        $mis_actividades = [];
        if (Auth::check()) {
            $mis_actividades = Auth::user()->actividades()->with('media')->get();
        }

        if ($request->ajax()) {
            // Esto sirve para el botón "Cargar más" de tu vista de inicio
            return view('actividades.partials.lista', compact('actividades'))->render();
        }

        return view('pagina.inicio', compact('actividades', 'mis_actividades'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        // Pasamos un objeto vacío y la operación para reutilizar vistas si fuera necesario
        return view('actividades.create', [
            'actividad' => new Actividades(),
            'oper' => 'create'
        ]);
    }

    /**
     * Guardar nueva actividad y bloquear campos mediante sesión
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'hora' => 'required|string',
            'lugar' => 'required|string',
            'precio' => 'required|numeric',
            'cupos' => 'required|numeric',
        ]);

        // Creamos el registro
        Actividades::create($validated);

        /**
         * REDIRECCIÓN CLAVE:
         * Al usar back(), regresamos a la vista 'create'.
         * El "with('success', ...)" activará el @if(session('success')) en tu Blade,
         * ocultando el formulario y mostrando el botón de volver al inicio.
         */
        return back()->with('success', '¡La actividad se ha creado con éxito!');
    }

    /**
     * Mostrar una actividad específica
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
     * Actualizar actividad
     */
    public function update(Request $request, Actividades $actividad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'hora' => 'required|string',
            'lugar' => 'required|string',
            'precio' => 'required|numeric',
            'cupos' => 'required|numeric',
        ]);

        $actividad->update($validated);

        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada correctamente.');
    }

    /**
     * Eliminar actividad
     */
    public function destroy(Actividades $actividad)
    {
        $actividad->delete();
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada correctamente.');
    }

    /**
     * Método para inscribir usuario (AJAX que usas en tu vista de inicio)
     */
    public function inscribir($id)
    {
        // Aquí iría tu lógica de inscripción (ej: tabla pivote user_actividad)
        // Ejemplo rápido:
        return response()->json([
            'success' => true,
            'message' => 'Inscripción completada'
        ]);
    }
}