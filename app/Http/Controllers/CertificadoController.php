<?php

namespace App\Http\Controllers;
use App\User;
use App\Afiliado;
use App\Tipo_de_documento;
use App\Titulo;
use App\Categoria;
use App\Parametro;

use Auth;
use QrCode;
use PDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AfiliadoController;
use App\Http\Controllers\FxC;
use App\Http\Controllers\GenericController;



class CertificadoController extends Controller
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


    public function viewCertificado($codigo)
    {
        
        $titulo = '';
        $afiliado_id = Auth::user()->afiliado_id;
        $Afiliado = Afiliado::where('id_afiliado', $afiliado_id)->first();
        $hash_calculado = md5(ENV('PREFIJO_HASH').$afiliado_id);
        $AfiliadoController = New AfiliadoController();
        $enlace_descarga = '';
        $mensaje_error = '';

        if ($AfiliadoController->matriculaAlDia($afiliado_id)) {

            if ($codigo == 1) {
                $titulo = 'Constancia de Matricula';
                $enlace_descarga = env('PATH_PUBLIC').'certificado/matricula/'.Auth::user()->afiliado_id.'/'.$hash_calculado;
            }
            
            if ($codigo == 2) {
                $titulo = 'Certificado de Ética';
                $enlace_descarga = env('PATH_PUBLIC').'certificado/etica/'.Auth::user()->afiliado_id.'/'.$hash_calculado;
            }
        }
        else {
            $titulo = 'Error';
            $mensaje_error = 'El pago de su matricula no está al día, necesitamos que regularice su situación en el Colegio Colbitralar. para mas información, comuníquese con nuestra linea de atención: <a href="https://api.whatsapp.com/send/?phone=54938048852277&text=Hola%20tengo%20problemas%20para%20ingresar%20al%20sistema%20de%20auto-gestion%20de%20Colbitralar" target="_blank">Enviar WhatsApp a 3804-885227</a>';
        }

        return View('descargar-certificado')
        ->with('codigo', $codigo)
        ->with('mensaje_error', $mensaje_error)
        ->with('titulo', $titulo)
        ->with('enlace_descarga', $enlace_descarga); 
    }

    public function printCertificadoMatriculaPDF($afiliado_id, $hash)
    {  
        $hash_calculado = md5(ENV('PREFIJO_HASH').$afiliado_id);
        if ($hash_calculado == $hash) {
            error_reporting(E_ALL ^ E_DEPRECATED);
            $Afiliado = Afiliado::find($afiliado_id);

            $url_qrcode = ENV('PATH_PUBLIC').'validar/certificado-matricula/'.$afiliado_id.'/'.$hash;
            $dir_imagen = env('PATH_PUBLIC_INTERNO').'qrcode/afiliados/afiliado-'.$afiliado_id.'.png';
            $dir_imagen_url = env('PATH_PUBLIC').'qrcode/afiliados/afiliado-'.$afiliado_id.'.png';

            QrCode::format('png');
            QrCode::size(200);
            QrCode::generate($url_qrcode, $dir_imagen);


            $Tipo_de_documento = Tipo_de_documento::find($Afiliado->tb_tipo_de_documento);
            $Titulo = Titulo::find($Afiliado->tb_titulo);
            $Categoria = Categoria::find($Titulo->tb_categoria);
            $Parametro_nombre_presidente = Parametro::find(7);
            $Parametro_matricula_presidente = Parametro::find(8);
            $hoy = getdate();
            $diaHoy = $hoy['mday'];
            $FxC = New FxC();
            $mesHoy = $FxC->nombre_de_mes($hoy['mon']);
            $anioHoy = $hoy['year'];
            $pronombre = '';
            
            if ($Afiliado->tb_sexo == 1) {
                $pronombre = 'el';
            }
            else {
                $pronombre = 'la';
            }


            $data = [
                'Afiliado' => $Afiliado, 
                'pronombre' => $pronombre, 
                'diaHoy' => $diaHoy, 
                'mesHoy' => $mesHoy, 
                'anioHoy' => $anioHoy, 
                'abreviacion' => $Titulo->abreviacion, 
                'categoria' => $Categoria->categoria, 
                'nemotecnico' => $Tipo_de_documento->nemotecnico, 
                'nombre_presidente' => $Parametro_nombre_presidente->valor, 
                'matricula_presidente' => $Parametro_matricula_presidente->valor, 
                'nemotecnico' => $Tipo_de_documento->nemotecnico, 
                'dir_imagen_url' => $dir_imagen_url
            ];

            $pdf = PDF::loadView('pdf.certificado-matricula-pdf', $data)->setPaper('c4', 'vertical');

            //return $pdf->download('certificado-matricula-'.$Afiliado->nro_de_matricula.'.pdf');    
            return $pdf->stream();
        }
        else {
            echo 'ERROR';
        }  

    }

    public function validarCertificadoMatricula($afiliado_id, $hash)
    {  
        $hash_calculado = md5(ENV('PREFIJO_HASH').$afiliado_id);
        if ($hash_calculado == $hash) {
            error_reporting(E_ALL ^ E_DEPRECATED);
            $Afiliado = Afiliado::find($afiliado_id);

            $dir_imagen_url = env('PATH_PUBLIC').'qrcode/afiliados/afiliado-'.$afiliado_id.'.png';
            $Tipo_de_documento = Tipo_de_documento::find($Afiliado->tb_tipo_de_documento);
            $Titulo = Titulo::find($Afiliado->tb_titulo);
            $Categoria = Categoria::find($Titulo->tb_categoria);
            $Parametro_nombre_presidente = Parametro::find(7);
            $Parametro_matricula_presidente = Parametro::find(8);
            $hoy = getdate();
            $diaHoy = $hoy['mday'];
            $FxC = New FxC();
            $mesHoy = $FxC->nombre_de_mes($hoy['mon']);
            $anioHoy = $hoy['year'];
            $pronombre = '';
            
            if ($Afiliado->tb_sexo == 1) {
                $pronombre = 'el';
            }
            else {
                $pronombre = 'la';
            }

            return View('pdf.certificado-matricula-pdf')
            ->with('Afiliado', $Afiliado)
            ->with('pronombre', $pronombre)
            ->with('diaHoy', $diaHoy)
            ->with('mesHoy', $mesHoy)
            ->with('anioHoy', $anioHoy)
            ->with('abreviacion', $Titulo->abreviacion)
            ->with('categoria', $Categoria->categoria)
            ->with('nemotecnico', $Tipo_de_documento->nemotecnico)
            ->with('nombre_presidente', $Parametro_nombre_presidente->valor)
            ->with('matricula_presidente', $Parametro_matricula_presidente->valor)
            ->with('dir_imagen_url', $dir_imagen_url); 
        }
        else {
            echo 'ERROR';
        }  

    }


    public function printCertificadoEticaPDF($afiliado_id, $hash)
    {  
        $hash_calculado = md5(ENV('PREFIJO_HASH').$afiliado_id);
        if ($hash_calculado == $hash) {
            error_reporting(E_ALL ^ E_DEPRECATED);
            $Afiliado = Afiliado::find($afiliado_id);

            $url_qrcode = ENV('PATH_PUBLIC').'validar/certificado-etica/'.$afiliado_id.'/'.$hash;
            $dir_imagen = env('PATH_PUBLIC_INTERNO').'qrcode/afiliados/afiliado-'.$afiliado_id.'.png';
            $dir_imagen_url = env('PATH_PUBLIC').'qrcode/afiliados/afiliado-'.$afiliado_id.'.png';

            QrCode::format('png');
            QrCode::size(200);
            QrCode::generate($url_qrcode, $dir_imagen);


            $Tipo_de_documento = Tipo_de_documento::find($Afiliado->tb_tipo_de_documento);
            $Titulo = Titulo::find($Afiliado->tb_titulo);
            $Categoria = Categoria::find($Titulo->tb_categoria);
            $Parametro_nombre_presidente = Parametro::find(7);
            $Parametro_matricula_presidente = Parametro::find(8);
            $hoy = getdate();
            $diaHoy = $hoy['mday'];
            $FxC = New FxC();
            $GenericController = New GenericController();
            $mesHoy = $FxC->nombre_de_mes($hoy['mon']);
            $anioHoy = $hoy['year'];
            $pronombre = '';
            
            if ($Afiliado->tb_sexo == 1) {
                $pronombre = 'el';
            }
            else {
                $pronombre = 'la';
            }


            $data = [
                'Afiliado' => $Afiliado, 
                'pronombre' => $pronombre, 
                'diaHoy' => $diaHoy, 
                'mesHoy' => $mesHoy, 
                'anioHoy' => $anioHoy, 
                'abreviacion' => $Titulo->abreviacion, 
                'titulo' => $Titulo->titulo, 
                'fecha_de_matriculacion' => $GenericController->FormatoFecha($Afiliado->fecha_de_matriculacion), 
                'categoria' => $Categoria->categoria, 
                'nemotecnico' => $Tipo_de_documento->nemotecnico, 
                'nombre_presidente' => $Parametro_nombre_presidente->valor, 
                'matricula_presidente' => $Parametro_matricula_presidente->valor, 
                'nemotecnico' => $Tipo_de_documento->nemotecnico, 
                'dir_imagen_url' => $dir_imagen_url
            ];

            $pdf = PDF::loadView('pdf.certificado-etica-pdf', $data)->setPaper('c4', 'vertical');

            //return $pdf->download('certificado-etica-'.$Afiliado->nro_de_etica.'.pdf');    
            return $pdf->stream();
        }
        else {
            echo 'ERROR';
        }  

    }

    public function validarCertificadoEtica($afiliado_id, $hash)
    {  
        $hash_calculado = md5(ENV('PREFIJO_HASH').$afiliado_id);
        if ($hash_calculado == $hash) {
            error_reporting(E_ALL ^ E_DEPRECATED);
            $Afiliado = Afiliado::find($afiliado_id);

            $dir_imagen_url = env('PATH_PUBLIC').'qrcode/afiliados/afiliado-'.$afiliado_id.'.png';
            $Tipo_de_documento = Tipo_de_documento::find($Afiliado->tb_tipo_de_documento);
            $Titulo = Titulo::find($Afiliado->tb_titulo);
            $Categoria = Categoria::find($Titulo->tb_categoria);
            $Parametro_nombre_presidente = Parametro::find(7);
            $Parametro_matricula_presidente = Parametro::find(8);
            $hoy = getdate();
            $diaHoy = $hoy['mday'];
            $FxC = New FxC();
            $GenericController = New GenericController();
            $mesHoy = $FxC->nombre_de_mes($hoy['mon']);
            $anioHoy = $hoy['year'];
            $pronombre = '';
            
            if ($Afiliado->tb_sexo == 1) {
                $pronombre = 'el';
            }
            else {
                $pronombre = 'la';
            }

            return View('pdf.certificado-etica-pdf')
            ->with('Afiliado', $Afiliado)
            ->with('pronombre', $pronombre)
            ->with('diaHoy', $diaHoy)
            ->with('mesHoy', $mesHoy)
            ->with('anioHoy', $anioHoy)
            ->with('abreviacion', $Titulo->abreviacion)
            ->with('titulo', $Titulo->titulo)
            ->with('fecha_de_matriculacion', $GenericController->FormatoFecha($Afiliado->fecha_de_matriculacion))
            ->with('categoria', $Categoria->categoria)
            ->with('nemotecnico', $Tipo_de_documento->nemotecnico)
            ->with('nombre_presidente', $Parametro_nombre_presidente->valor)
            ->with('matricula_presidente', $Parametro_matricula_presidente->valor)
            ->with('dir_imagen_url', $dir_imagen_url); 
        }
        else {
            echo 'ERROR';
        }  

    }


    public function certificadoMatricula($afiliado_id)
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
