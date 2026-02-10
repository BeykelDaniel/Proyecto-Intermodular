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

            // REDIRECCIÓN FORZADA A INICIO
            return redirect()->route('pagina.inicio')->with('success', '¡Has iniciado sesión con éxito!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Guardar nuevo usuario / Registro (Bloque Teja)
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

        $user = User::create($validated);

        // Loguear automáticamente tras registrarse
        Auth::login($user);

        // REDIRECCIÓN FORZADA A INICIO
        return redirect()->route('pagina.inicio')->with('success', '¡Cuenta creada e inicio de sesión exitoso!');
    }

    /**
     * Cerrar Sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pagina.login_usuarios');
    }

    // --- MÉTODOS DE GESTIÓN (CRUD) ---

    public function index()
    {
        $usuarios = User::paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create', ['usuario' => new User(), 'oper' => 'create']);
    }

    public function show(User $usuario)
    {
        return view('usuarios.create', ['usuario' => $usuario, 'oper' => 'show']);
    }

    public function edit(User $usuario)
    {
        return view('usuarios.create', ['usuario' => $usuario, 'oper' => 'edit']);
    }

    public function update(Request $request, User $usuario)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($usuario->id)],
            'fecha_nacimiento' => 'required|date',
            'genero' => ['required', Rule::in(['hombre', 'mujer'])],
            'numero_telefono' => 'required|string|max:20',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }
        else {
            unset($validated['password']);
        }

        $usuario->update($validated);
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}