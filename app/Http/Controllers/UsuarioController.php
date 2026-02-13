<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Procesar el Login (Bloque Azul)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('pagina.inicio')->with('success', '¡Has iniciado sesión con éxito!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Guardar nuevo usuario / Añadir Amigo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:hombre,mujer',
            'numero_telefono' => 'required|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Creamos el usuario
        User::create($validated);

        // Si el que está creando el usuario es el Administrador logueado,
        // nos quedamos en la página con un mensaje de éxito para BLOQUEAR campos.
        if (Auth::check() && Auth::user()->email == 'cabrerajosedaniel89@gmail.com') {
            return back()->with('success', '¡Amigo añadido correctamente a la lista!');
        }

        // Si es un registro normal de un usuario nuevo desde fuera:
        Auth::login(User::where('email', $validated['email'])->first());
        return redirect()->route('pagina.inicio');
    }

    // --- MÉTODOS DE GESTIÓN (CRUD) ---

    public function index()
    {
        $usuarios = User::paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        // Usamos la misma vista que para edit pero vacía
        return view('usuarios.create', ['usuario' => new User(), 'oper' => 'create']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('pagina.login_usuarios');
    }

// ... Resto de métodos (show, edit, update, destroy) se mantienen igual
}