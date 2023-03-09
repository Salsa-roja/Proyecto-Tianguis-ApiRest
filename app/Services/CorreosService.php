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

    public static function guardar($params){
        try {
            # Guardar en bd respaldo del correo
            $itemDB = new Correo();
            $itemDB->remitente = $params['remitente'];
            $itemDB->destinatario = $params['destinatario'];
            $itemDB->asunto = $params['asunto'];
            $itemDB->cuerpo = $params['cuerpo'];

            $itemDB->save();
            return $itemDB;
        } catch (\Exception $e) {
            return response()->json([   'error' => $e->getMessage(),
                                        'funcion' => 'guardarYEnviar'
                                    ], 500);
        }
      
    }

    /**
     * Enviar notificacion por correo electronico
     *
     * @param  array ['remitente','destinatario','asunto','cuerpo','titulo','template'] - All required
     * @return []
    */
    public static function guardarYEnviar($params){
        try {
            //CorreosService::guardar($params);
            $remitente = !is_null($params['remitente']) ? Usuarios::find($params['remitente']):[];
            $destinatario = Usuarios::find($params['destinatario']);
            $template = isset($params['template']) ? $params['template'] : '/mail/mail';

            $data['remitente'] = $remitente;
            $data['destinatario'] = $destinatario;
            $data['params'] = $params;

            return Mail::send($template,
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
    public static function notificacionVacanteVista ($params){
        try {
            //CorreosService::guardar($params);
            $remitente = !is_null($params['remitente']) ? Usuarios::find($params['remitente']):[];
            $destinatario = Usuarios::find($params['destinatario']);
            $template = isset($params['template']) ? $params['template'] : '/mail/mail';

            $data['remitente'] = $remitente;
            $data['destinatario'] = $destinatario;
            $data['params'] = $params;

            return Mail::send($template,
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
