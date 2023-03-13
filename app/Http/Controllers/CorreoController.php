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

            $data = array(
                'from_mail' => null,
                'from_name' => null,
                'to_mail' => 'aguet97@gmail.com',
                'to_name' => 'Alonso Aguet',
                'asunto' => 'Broadcast Correo',
                'cuerpo' => $request['htmlContent'],
                'titulo' => '',
                'template' => 'mail/broadcast'
            );

            CorreosService::guardarYEnviar($data);
            return $request;
        } catch (\Exception $ex) {
            return response()->json([   'error' => $ex->getMessage(),
                                        'funcion' => 'CorreoController->broadcast()'
                                    ], 500);
        }
    }//...broadcast
}
