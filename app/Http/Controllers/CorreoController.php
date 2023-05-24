<?php

namespace App\Http\Controllers;

use App\Models\Correo;
use App\Services\CorreosService;
use App\Services\SocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Dto\ParseDto;
use App\Models\Usuarios;
use App\Models\Solicitante;
use App\Models\Empresa;

class CorreoController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    } 
 

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

    public function broadcast(){
        try {

            $params = $this->request->all();

            $mail = array(
                'from_mail' => 'no-reply@quierochamba.com',
                'from_name' => 'Equipo de soporte - Quiero Chamba',
                //'to_mail' => 'aguet97@gmail.com',
                //'to_name' => 'Alonso Aguet',
                'asunto' => $this->request['asunto'],
                'cuerpo' => $this->request['htmlContent'],
                'titulo' => $this->request['asunto'],
                'template' => 'mail/broadcast'
            );

            //$usuariosActivos = Usuarios::where('activo', true)->pluck('id')->toArray();
            $params['destinatarios'] = [];
            switch ($this->request['tipo_usuario']) {
                case 1:
                    # Ciudadanos
                    $ciudadanos = Solicitante::with(['rel_usuarios'=>function ($query){
                        $query->where('activo',true);
                    }])->get();

                    //$ciudadanos = Solicitante::with(['rel_usuarios'])->whereIn('id_usuario', $usuariosActivos)->get();
                    
                    foreach ($ciudadanos as $k => $v) {
                        if( !is_null($v->rel_usuarios) ){
                            array_push($params['destinatarios'], $v->rel_usuarios);
                        }
                    }
                    break;
                
                default:
                    # Empresas
                    $empresas = Empresa::with(['usuario_empresa.rel_usuarios'=>function ($query){
                        $query->where('activo',true);
                    }])->where('activo',true)->get();

                    //$params['destinatarios']=$empresas;
                    foreach ($empresas as $e) {

                        foreach ($e->usuario_empresa as $u) {
                            if(!is_null($u->rel_usuarios)){
                                array_push($params['destinatarios'],$u->rel_usuarios);
                            }
                        }
                    
                    }

                    break;
            }

            # Por cada usuario notificar via correo y socket

            # Inicializar el websocket
            $Ssv = new SocketService($this->request->auth, 'notify_client');

            foreach ($params['destinatarios'] as $d) {
                # Notificar por correo
                if($d->correo!=''){
                    $mail['to_mail'] = $d->correo;
                    $mail['to_name'] = $d->nombres;
                    CorreosService::guardarYEnviar($mail);
                }
                # Almacenar nueva notificacion en la cola del socket
                $Ssv->addToQueque([
                    'id_usuario'=>$d->id,
                    'sala'=>"user_$d->id",
                    'titulo'=>$mail['asunto'],
                    'descripcion'=>$mail['cuerpo']
                ]);
            }
            $Ssv->emitQueque()->close();

            return $params;
        } catch (\Exception $ex) {
            return response()->json([   'error' => $ex->getMessage(),
                                        'funcion' => 'CorreoController->broadcast()'
                                    ], 500);
        }
    }//...broadcast
}
