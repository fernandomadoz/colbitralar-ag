
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(isset($Mensaje))
            <h4>{{ $Mensaje }}</h4>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">Registrarse</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('afiliado') ? ' has-error' : '' }}">

                                @if ($errors->has('afiliado'))
                                    @if ($errors->first('afiliado') == 'El campo afiliado es obligatorio.')

                                      <section class="content-header">
                                        <div class="row">    
                                          <div class="col-xs-12">
                                            <br>
                                            <div class="alert alert-warning alert-dismissible">
                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                              <strong><i class="icon fa fa fa-ban"></i> El Nro. de Documento y el Nro. de Matrícula no corresponden a un Afiliado registrado</strong>  
                                            </div>
                                          </div>   
                                        </div>
                                      </section> 
                                    @endif
                                @endif

                                @if ($errors->has('registrado'))
                                    @if ($errors->first('registrado') == 'El campo registrado es obligatorio.')

                                      <section class="content-header">
                                        <div class="row">    
                                          <div class="col-xs-12">
                                            <br>
                                            <div class="alert alert-warning alert-dismissible">
                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                              <strong><i class="icon fa fa fa-ban"></i> Ya se ha registrado en este sistema un usuario con el Nro. de Documento y el Nro. de Matrícula que ha proporcionado. Si ha sido Ud. haga click aqui: <a href="{{ route('password.request') }}">Recuperar la Contraseña</a>.<br><br> Si no ha sido usted, comuníquese con nuestra linea de atención: <a href="https://api.whatsapp.com/send/?phone=54938048852277&text=Hola%20tengo%20problemas%20para%20ingresar%20al%20sistema%20de%20auto-gestion%20de%20Colbitralar" target="_blank">Enviar WhatsApp a 3804-885227</a></strong>  
                                            </div>
                                          </div>   
                                        </div>
                                      </section> 
                                    @endif
                                @endif

                                @if ($errors->has('aldia'))
                                    @if ($errors->first('aldia') == 'El campo aldia es obligatorio.')

                                      <section class="content-header">
                                        <div class="row">    
                                          <div class="col-xs-12">
                                            <br>
                                            <div class="alert alert-warning alert-dismissible">
                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                              <strong><i class="icon fa fa fa-ban"></i> El pago de su matricula no está al día, necesitamos que regularice su situación en el Colegio Colbitralar. para mas información, comuníquese con nuestra linea de atención: <a href="https://api.whatsapp.com/send/?phone=54938048852277&text=Hola%20tengo%20problemas%20para%20ingresar%20al%20sistema%20de%20auto-gestion%20de%20Colbitralar" target="_blank">Enviar WhatsApp a 3804-885227</a></strong>  
                                            </div>
                                          </div>   
                                        </div>
                                      </section> 
                                    @endif
                                @endif
                        </div>

                        <!--div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label"><?php echo __('Nombre') ?></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div-->

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label"><?php echo __('Correo Electrónico') ?></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label"><?php echo __('Contraseña') ?></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label"><?php echo __('Confirmar Contraseña') ?></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('nro_de_documento') ? ' has-error' : '' }}">
                            <label for="nro_de_documento" class="col-md-4 control-label"><?php echo __('Nro. de Documento') ?></label>

                            <div class="col-md-6">
                                <input id="nro_de_documento" type="text" class="form-control" name="nro_de_documento" required>

                                @if ($errors->has('nro_de_documento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nro_de_documento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('nro_de_matricula') ? ' has-error' : '' }}">
                            <label for="nro_de_matricula" class="col-md-4 control-label"><?php echo __('Nro. de Matrícula') ?></label>

                            <div class="col-md-6">
                                <input id="nro_de_matricula" type="text" class="form-control" name="nro_de_matricula" required>

                                @if ($errors->has('nro_de_matricula'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nro_de_matricula') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo __('Registrarme') ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
