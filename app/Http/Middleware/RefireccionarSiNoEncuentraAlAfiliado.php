<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefireccionarSiNoEncuentraAlAfiliado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $Usuario = DB::connection('sistema')
        ->table('tb_afiliado')
        ->select('id_afiliado')
        ->where('nro_de_documento', $request['nro_de_documento'])
        ->where('nro_de_matricula', $request['nro_de_matricula'])
        ->get();

        if ($Usuario->count() == 0) {
            return redirect()->back()->with('Mensaje', 'Afiliado no encontrado');
        }

        return $next($request);
    }
}
