<?php
$rol_de_usuario_id = Auth::user()->rol_de_usuario_id;
?>


@extends('layouts.backend')



@section('contenido')

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo env('PATH_PUBLIC')?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo env('PATH_PUBLIC')?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo env('PATH_PUBLIC')?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo env('PATH_PUBLIC')?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo env('PATH_PUBLIC')?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo env('PATH_PUBLIC')?>dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inicio
        <small>Descargar Certificado</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active">Descargar Certificado</li>
      </ol>
    </section>

    <div class="content" style="min-height: 115px;">

      @if ($mensaje_error == '')

      <section class="content">
        <div class="row">
          <h2><?php echo $titulo ?></h2>
          <a href="<?php echo $enlace_descarga ?>" target="_blank">
            <button type="button" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-cloud-download"></i> Descargar</button>
          </a>

        </div>
      </section>

      @else
      <section class="content-header">
        <div class="row">    
          <div class="col-xs-12">
            <h2><?php echo $titulo ?></h2>
            <br>
            <div class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <strong><i class="icon fa fa fa-ban"></i> El pago de su matricula no está al día, necesitamos que regularice su situación en el Colegio Colbitralar. para mas información, comuníquese con nuestra linea de atención: <a href="https://api.whatsapp.com/send/?phone=54938048852277&text=Hola%20tengo%20problemas%20para%20ingresar%20al%20sistema%20de%20auto-gestion%20de%20Colbitralar" target="_blank">Enviar WhatsApp a 3804-885227</a></strong>  
            </div>
          </div>   
        </div>
      </section> 

      @endif

    </div>

<!-- DataTables -->
<script src="<?php echo env('PATH_PUBLIC')?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo env('PATH_PUBLIC')?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>



@endsection
