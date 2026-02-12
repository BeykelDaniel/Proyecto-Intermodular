<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividades;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ActividadesController extends Controller
{

    public function index(Request $request)
    {
        // 1. Traemos los datos paginados
        $actividades = \App\Models\Actividades::orderBy('fecha', 'asc')->paginate(4);

        // 2. Si es una petición del botón (AJAX), enviamos solo la lista
        if ($request->ajax()) {
            return view('actividades.partials.lista', compact('actividades'))->render();
        }

        // 3. Si es la carga normal, enviamos toda la página
        return view('pagina.inicio', compact('actividades'));
    }



    public function create()
    {
        return view('actividades.create', ['actividad' => new Actividades(), 'oper' => 'create']);
    }

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

        Actividades::create($validated);
        return redirect()->route('actividades.index')->with('success', 'Actividad creada correctamente.');
    }

    public function show(Actividades $actividad)
    {
        return view('actividades.create', ['actividad' => $actividad, 'oper' => 'show']);
    }

    public function edit(Actividades $actividad)
    {
        return view('actividades.create', ['actividad' => $actividad, 'oper' => 'edit']);
    }

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

    public function destroy(Actividades $actividad)
    {
        $actividad->delete();
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada correctamente.');
    }
}