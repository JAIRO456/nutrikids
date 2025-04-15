<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
 
    public function login(Request $request)
    {
        $request->validate([
            'documento' => 'required',
            'password' => 'required',
        ]);

        $user = Usuario::where('documento', $request->documento)->first();

        if (!$user) {
            return back()->withErrors(['documento' => 'El usuario no existe']);
        }

        if ($user->id_estado == 2) {
            return back()->withErrors(['documento' => 'Usuario inactivo']);
        }

        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            session([
                'documento' => $user->documento,
                'rol' => $user->id_rol,
                'estate' => $user->id_estado
            ]);

            switch ($user->id_rol) {
                case 1:
                    return redirect()->to('/admin/inicio');
                case 2:
                    return redirect()->to('/coordinador/inicio');
                case 3:
                    return redirect()->to('/vendedor/inicio');
                case 4:
                    return redirect()->to('/acudiente/inicio');
            }
        }

        return back()->withErrors(['password' => 'Contraseña incorrecta']);
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }
}

