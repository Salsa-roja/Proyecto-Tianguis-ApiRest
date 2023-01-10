<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Correo;
use App\Models\Usuarios;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailService;
//use App\Models\UserNotifiable;
//use App\Notifications\EmailSimple;
//use App\Mail\Notification;

class CorreosService
{

    public static function correoById($correo_id){
        try {
            return Correo::find($correo_id);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function guardarYEnviar($params){
        try {
            /* 
            # Guardar en bd respaldo del correo
            $itemDB = new Correo();
            $itemDB->remitente = $params['remitente'];
            $itemDB->destinatario = $params['destinatario'];
            $itemDB->asunto = $params['asunto'];
            $itemDB->cuerpo = $params['cuerpo'];

            $itemDB->save(); */

            $remitente = Usuarios::find($params['remitente']);
            $destinatario = Usuarios::find($params['destinatario']);

            $data['remitente'] = $remitente;
            $data['destinatario'] = $destinatario;
            $data['params'] = $params;

            return Mail::send('/mail/mail',
                                compact('data'),
                                function($message) use($params,$remitente,$destinatario) { 
                                    $message->to($destinatario->correo, $destinatario->nombres.' '.$destinatario->ape_paterno)
                                            ->subject($params['asunto'])
                                            ->from(env("MAIL_FROM_ADDRESS"),env("MAIL_FROM_NAME"))
                                            ; 
                                }
            );
            //$user = UserNotifiable::find($params['remitente']);
            //genera error: Please provide a valid cache path. 
            //$user->notify(new EmailSimple($itemDB));
            //return $itemDB;

            /* return [
                    "correo"=>$correo, 
                    "remitente"=>$remitente, 
                    "destinatario"=>$destinatario
                ]; */
        } catch (\Exception $e) {
            return response()->json([   'error' => $e->getMessage(),
                                        'funcion' => 'guardarYEnviar'
                                    ], 500);
        }
    }

}
