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

    }//...enviar

    public function get_hosts(){
        if (dns_get_mx("hotmail.com", $mxhosts, $mxweights)) {
            for ($i=0; $i<count($mxhosts); $i++) {
                echo "Host: ".$mxhosts[$i]." - Peso: ".$mxweights[$i]."<br>";
            }
        } else {
            echo "No se encontraron registros MX para el dominio especificado.";
        }
    }

    public function broadcast(Request $request){
        try {
            $params = $request['params'];
            return $request;
        } catch (\Exception $ex) {
            return response()->json([   'error' => $ex->getMessage(),
                                        'funcion' => 'CorreoController->broadcast()'
                                    ], 500);
        }
    }//...broadcast
}
