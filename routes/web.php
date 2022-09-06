<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



	

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');

	Route::get('/micuenta', 'HomeController@miCuenta');

	// RUTAS GENERICAS
	Route::post('/crearlista', 'GenericController@crearLista');
	Route::post('/crearabm', 'GenericController@crearABM');
	Route::post('/enviarabm/{gen_modelo}', 'GenericController@crearABM');
	Route::post('/store', 'GenericController@store');
	Route::get('/list/{gen_modelo}/{gen_opcion}', 'GenericController@index');
	// FIN RUTAS GENERICAS

	Route::post('change-password', 'HomeController@changePassword');
	


});

//Certificados
Route::get('/certificado/view/{codigo}', 'CertificadoController@viewCertificado');
Route::get('/certificado/matricula/{afiliado_id}/{hash}', 'CertificadoController@printCertificadoMatriculaPDF');
Route::get('/certificado/etica/{afiliado_id}/{hash}', 'CertificadoController@printcertificadoEticaPDF');
Route::get('/validar/certificado-matricula/{afiliado_id}/{hash}', 'CertificadoController@validarCertificadoMatricula');
Route::get('/validar/certificado-etica/{afiliado_id}/{hash}', 'CertificadoController@validarCertificadoEtica');


Route::get('/prueba', function () {
    return view('prueba');
});	


Auth::routes();

Route::get('/delcache', function () {
    $exitCode = Artisan::call('cache:clear');
    echo 'Cache Borrada';
});

Route::get('/procesar', 'ImportarAfiliadosController@procesar');



//FORMS
