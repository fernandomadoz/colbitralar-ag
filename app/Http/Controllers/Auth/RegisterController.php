<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AfiliadoController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Busco si existe el Afiliado en el Sistema de Gestión
        $Afiliado = DB::connection('sistema')
        ->table('tb_afiliado')
        ->select('id_afiliado')
        ->where('nro_de_documento', $data['nro_de_documento'])
        ->where('nro_de_matricula', $data['nro_de_matricula'])
        ->get();
        
        $afiliado_requerido = '';
        $registrado_requerido = '';
        $aldia_requerido = '';
        
        if ($Afiliado->count() == 0) {
            // Si no existe el afiliado con esos datos aviso
            $afiliado_requerido = 'required';
        }
        else {
            // Si existe el afiliado verifico que no exista un usuario con ese afiliado
            $id_afiliado = $Afiliado[0]->id_afiliado;
            $Usuario = User::where('afiliado_id', $id_afiliado)->get();
            if ($Usuario->count() > 0) {
                // Si lo encuentra aviso que ya esta registrado
                $registrado_requerido = 'required';
            }
            else {
                // Si no lo encuentra verifico que este al dia con la matriculación
                $AfiliadoController = new AfiliadoController();
                $aldia = $AfiliadoController->matriculaAlDia($id_afiliado);

                if (!$aldia) {
                    // si no esta al dia aviso
                    $aldia_requerido = 'required';
                }
            }
        }

        return  Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nro_de_documento' => 'required|string',
            'nro_de_matricula' => 'required|string',
            'afiliado' => $afiliado_requerido,
            'registrado' => $registrado_requerido,
            'aldia' => $aldia_requerido,
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
           
        
        $Usuario = DB::connection('sistema')
        ->table('tb_afiliado')
        ->select('id_afiliado', 'nombre', 'apellido')
        ->where('nro_de_documento', $data['nro_de_documento'])
        ->where('nro_de_matricula', $data['nro_de_matricula'])
        ->get();

        return User::create([
            'name' => $Usuario[0]->nombre.' '.$Usuario[0]->apellido,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'afiliado_id' => $Usuario[0]->id_afiliado,
            'rol_de_usuario_id' => 2,
            ]);
    
        


        
    }
}
