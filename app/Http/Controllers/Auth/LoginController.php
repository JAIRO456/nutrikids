<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     $this->middleware('auth')->only('logout');
    // }

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

        $user = User::where('documento', $request->documento)->first();

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
