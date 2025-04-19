<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Producto;
use App\Models\Estudiante;
use App\Models\Categoria;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('admin.inicio', compact('user'));
    }

    public function getCounts()
    {
        $counts = [
            'TotalProducts' => DB::table('producto')->count(),
            'TotalUser' => DB::table('usuarios')->count(),
            'TotalEstudiantes' => DB::table('estudiantes')->count(),
            'TotalSchools' => DB::table('escuelas')->count(),
        ];

        return response()->json($counts);
    }

    public function getLatest()
    {
        $users = User::orderBy('documento', 'asc')->take(5)->get(['nombre', 'apellido', 'email']);
        $products = Producto::with('categorias')->orderBy('id_producto', 'asc')->take(5)->get(['nombre_prod', 'id_categoria', 'precio']);
        
        return response()->json([
            'users' => $users,
            'products' => $products,
        ]);
    }

    /* -------------------------------- */

    public function index_roles()
    {
        $user = Auth::user();
        
        return view('admin.roles', compact('user'));
    }

    public function getRoles()
    {
        $users = User::with('roles', 'estados')->orderBy('documento', 'asc')->get(['imagen', 'documento', 'nombre', 'id_rol', 'id_estado']);
        
        return response()->json([
            'users' => $users,
        ]);
    }
    
    /* -------------------------------- */

    public function index_menus()
    {
        $user = Auth::user();
        
        return view('admin.menus', compact('user'));
    }

    public function getMenus()
    {
        $menus = Estudiante::with('estados')->orderBy('documento_est', 'asc')->get(['imagen_est', 'documento_est', 'nombre_est', 'apellido_est', 'id_estado']);
        
        return response()->json([
            'menus' => $menus,
        ]);
    }
    
    /* -------------------------------- */

    public function index_productos()
    {
        $user = Auth::user();
        $categories = Categoria::orderBy('categoria', 'asc')->get();
        
        return view('admin.productos', compact('user', 'categories'));
    }
}
