<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login.
     */
    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Procesar el login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ], [
            'usuario.required' => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Buscar el usuario por nombre de usuario
        $usuario = Usuario::where('usuario', $request->usuario)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return back()
                ->withInput($request->only('usuario'))
                ->withErrors(['usuario' => 'Las credenciales son incorrectas.']);
        }

        // Autenticar al usuario
        Auth::guard('web')->login($usuario);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Cerrar sesión.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
