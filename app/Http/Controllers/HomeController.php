<?php

namespace App\Http\Controllers;
use App\Solicitud;
use App\User;
use App\Pais;
use App\Idioma;
use App\Inscripcion;
use App\Fecha_de_evento;
use App\Afiliado;

use Auth;
use Validator;
use Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ExtController;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //$Solicitudes = Solicitud::all();

        return View('welcome');
    }



    public function miCuenta()
    {   
        $user_id = Auth::user()->id;
        $afiliado_id = Auth::user()->afiliado_id;
        $User = User::find($user_id);
        $Afiliado = Afiliado::where('id_afiliado', $afiliado_id)->first();


        return View('mi-cuenta')
        ->with('User', $User)
        ->with('Afiliado', $Afiliado);
    }



    
    public function changePassword(Request $request) {
        $reglas = [
            'mypassword' => 'required',
            'password' => 'required|confirmed|min:6|max:18'
        ];

        $mensajes = [
            'mypassword.required' => 'El campo es requerido',
            'password.required' => 'El campo es requerido',
            'password.confirmed' => 'Los password no coinciden',
            'password.min' => 'El mínimo de caracteres es 6',
            'password.max' => 'El máximo de caracteres es 18',

        ];


        $validator = Validator::make($request->all(), $reglas, $mensajes);
        
        if ($validator->fails()) {
            $mensaje = 'error';
            return redirect(ENV('PATH_PUBLIC').'micuenta')->withErrors($validator)->with('mensaje', $mensaje);
        }
        else {
            if (Hash::check($request->mypassword, Auth::user()->password)) {
                $user = New User;
                $user->where('email', Auth::user()->email)
                ->update(['password' => bcrypt($request->password)]);

                $mensaje = 'Actualizacion de contraseña realizada exitosamente';

                return redirect(ENV('PATH_PUBLIC').'micuenta')
                ->with('mensaje', $mensaje);   
            }
            else {
                $mensaje['detalle'] = 'Error! La contraseña original no es la correcta';
                $mensaje['class'] = 'alert-warning';
                $mensaje['error'] = true;

                return redirect(ENV('PATH_PUBLIC').'micuenta')
                ->with('mensaje', $mensaje);   
            }
        }

    }

}
