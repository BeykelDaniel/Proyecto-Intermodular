<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Muestra la vista de login.
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Maneja el intento de autenticación.
     */
    public function authenticate(Request $request)
    {
        // 1. Validar los datos de entrada
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Intentar el login
        if (Auth::attempt($credentials)) {
            // Regenerar la sesión por seguridad
            $request->session()->regenerate();

            // 3. REDIRECCIÓN SEGÚN USUARIO
            // Si el correo coincide con el tuyo, vas al panel de administración
            if ($request->email === 'cabrerajosedaniel89@gmail.com') {
                return redirect()->route('dashboard');
            }

            // Para el resto de usuarios, van a la página principal de la app
            return redirect()->route('pagina.inicio');
        }

        // 4. Si el login falla, volver atrás con error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir a la raíz después de salir
        return redirect('/');
    }
}