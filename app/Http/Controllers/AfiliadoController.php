<?php

namespace App\Http\Controllers;
use App\User;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ExtController;



class AfiliadoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function matriculaAlDia($id_afiliado)
    { 

        $Vencimiento = DB::connection('sistema')
        ->table('tb_parametro')
        ->select('valor')
        ->where('id_parametro', 4)
        ->first();

        $Pagos = DB::connection('sistema')
        ->table('tb_afiliado as a')
        ->select(DB::Raw('a.id_afiliado, YEAR(NOW()) anio_actual, MONTH(NOW()) mes_actual, DAY(NOW()) dia_actual, YEAR(a.fecha_de_matriculacion) anio_matriculacion, COUNT(DISTINCT ma.anio) cant_anios_pagados, a.matriculacion_cancelada'))
        ->leftjoin('tb_pago_matriculacion_inicial as mi', 'mi.tb_afiliado', '=', 'a.id_afiliado')
        ->leftjoin('tb_matriculacion_anual as ma', function ($join) {
            $sino = '"SI"';
            $join->on('ma.tb_afiliado', '=', 'a.id_afiliado')->on('ma.matriculacion_cancelada', '=',DB::Raw($sino));
        })
        ->where('a.id_afiliado', $id_afiliado)
        ->groupBy(DB::Raw('a.id_afiliado, a.fecha_de_matriculacion, a.matriculacion_cancelada'))
        ->get();

        //dd($Pagos);

        $aldia = false;

        $anios = 1;
        
        if ($Pagos->count() >= 1) {

            $venc_valor_array = explode('/',$Vencimiento->valor);
            $dia_venc = $venc_valor_array[0];
            $mes_venc = $venc_valor_array[1];

            $Pagos = $Pagos[0];
            $anio_actual = $Pagos->anio_actual;
            $mes_actual = $Pagos->mes_actual;
            $dia_actual = $Pagos->dia_actual;
            $anio_matriculacion = $Pagos->anio_matriculacion;
            $cant_anios_pagados = $Pagos->cant_anios_pagados;
            $matriculacion_cancelada = $Pagos->matriculacion_cancelada;

            $anios = $anio_actual-$anio_matriculacion-$cant_anios_pagados;
            if ($matriculacion_cancelada == 'SI') {
                $anios--;
            }
            if ($mes_venc >= $mes_actual) {
                $anios--;
            }

        }

        if ($anios <= 0) {
            $aldia = true;
        }

        return $aldia;


    }


}
