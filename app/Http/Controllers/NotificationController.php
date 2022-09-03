<?php

namespace App\Http\Controllers;
use App\User;

use Auth;
use Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\GenericController;
use App\Mail\NotificacionEmail;

class NotificationController extends Controller
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


    public function enviarNotificacion($medio, $user_id, $mensaje, $email = '')
    {   
        //$medio
        //0 = todos
        //1 = telegram
        //2 = e-mail
        
        $Mensaje = 'Email Enviado';
        
        if (env('APP_ENV') <> 'development' or 1==1) {
            $destinatario = User::find($user_id);

            if ($medio == 0 or $medio == 1) {
                $chat_id = $destinatario->telegram_chat_id;

                if ($chat_id <> '') {
                    $GenericController = new GenericController();
                    $gen_campos = $GenericController->enviarTelegram($chat_id, $mensaje);        
                }             
            }

            if ($medio == 0 or $medio == 2) {
                if ($email <> '') {
                    $destinatario->email = $email;
                    Mail::to($destinatario)->send(new NotificacionEmail($mensaje));  
                    $Mensaje = 'Email Enviado';
                }
                else {
                    $mail = $destinatario->email;
                    if ($mail <> '') {
                        Mail::to($destinatario)->send(new NotificacionEmail($mensaje));       
                    }
                }
                  
            }
        }

        return $Mensaje;

    }


}
