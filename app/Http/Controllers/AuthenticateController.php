<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Caffeinated\Shinobi\Models\Permission;
use Caffeinated\Shinobi\Models\Role;
use App\User;
//use App\Employee;

class AuthenticateController extends Controller
{
    //Trait
    //use AuthenticatesUsers;

    public function login(Request $request) {
        $rules = [
            'name'  => 'required|string|max:255',
            'password' => 'required|string|min:6'     
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }    

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password , 'activo' => true])) {
            $isAdmin = false;
            $request->session()->regenerate();
            if(Auth::user()->isAdmin()){     // --- Para saber si eres Admin con la funcion magica isAdmin
                $isAdmin = true;
            }
            //$roles = Auth::user()->getRoles();    // -- Lista de Roles asignados al usuario
            $permisos_user = Auth::user()->getPermissions();    // --- Lista de permisos asignados al usuario
            $id = Auth::id();
            $user = User::where('id',$id)->get();   // -- Datos del usuario

            return response()->json(["logging" => 1 , "user" => $user , "isAdmin" => $isAdmin , "permisos_user" => $permisos_user]);     
        }

        return response()->json(['logging' => 0 , 'error' => 'Usuario y/o Password son incorrectos !!!'], 401);
        
    }

    //funcion de login username
    public function username()
    {
        return 'name';
    }

    public function logout() {
        Auth::logout();
    }

}
