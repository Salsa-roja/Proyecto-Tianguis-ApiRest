<?php

namespace App\Http\Controllers;

use App\Models\Correo;
use App\Services\CorreosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CorreoController extends Controller
{
    public function correoById($correo_id){
        try {
            $item =  CorreosService::correoById($correo_id);
            return response()->json($item, 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }

    }
    /**
     * Enviar notificacion por correo electronico
     *
     * @param  array ['remitente','destinatario','asunto','cuerpo','titulo'] - All required
     * @return response
     */
    public function enviar($params){
        try {
            $msg='';
            $status=false;
            $stCode=500;

            # Validar que vengan todos los datos
            if(array_search(null, $params) === false){
                # Validar envio del correo
                if(CorreosService::guardarYEnviar($params)){
                    $status=true;
                    $stCode=200; 
                }else{
                    $msg="Error al enviar correo";
                }
            }else{
                $msg="Es necesario proporcionar todos los campos";
            }

            return response()->json(['status'=>$status,'message'=>$msg,'params'=>$params],$stCode);
        } catch (\Exception $ex) {
            return response()->json([   'error' => $ex->getMessage(),
                                        'funcion' => 'CorreoController->enviar()'
                                    ], 500);
        }

    }
}